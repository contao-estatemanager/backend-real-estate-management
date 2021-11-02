<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/core
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\BackendRealEstateManagement;

use ContaoEstateManager\BackendRealEstateManagement\Exception\LayoutException;

/**
 * DOM Layout builder.
 *
 * Usage:
 *
 *  $layout = new LayoutBuilder();
 *
 *  $layout->addSection('sectionAlias');
 *  $layout->addHtml('<label>Hello World</label>');
 *  $layout->parse('sectionAlias');                                     // Returns => <label>Hello World</label>
 *
 *  ---
 *
 *  $layout->addSection('sectionAlias', 'div', ['class' => 'myClass']); // <- Set pointer to sectionAlias
 *  $layout->addSection('inputBag', 'nav');                             // <- Set pointer to inputBag
 *
 *  $layout->addHtml('<input type="text" value="Hello World">');
 *  $layout->append('sectionAlias')
 *  $layout->parse('sectionAlias');                                     // Returns: <div class="myClass"><nav><input type="text" value="Hello World"></nav></label>
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class LayoutBuilder
{
    public const TYPE_SECTION = 'section';
    public const TYPE_HTML = 'html';

    public string $blockSeparator = "\n";

    private array $sections = [];
    private string $currentSection;
    private array $children = [];

    /**
     * Adds a sections and set the pointer it.
     */
    public function addSection(string $alias, string $tag = null, array $attributes = null): self
    {
        if ($this->sectionExists($alias))
        {
            throw new LayoutException("Section with name $alias already exists.");
        }

        $this->sections[$alias] = [
            'alias' => $alias,
            'type' => self::TYPE_SECTION,
            'tag' => $tag,
            'attributes' => $attributes,
            'children' => null,
        ];

        $this->currentSection = $alias;

        return $this;
    }

    /**
     * Selects a section.
     */
    public function set($alias): self
    {
        if (!$this->sectionExists($alias))
        {
            throw new LayoutException("Section with name $alias do not exists.");
        }

        $this->currentSection = $alias;

        return $this;
    }

    /**
     * Add html content to section.
     */
    public function addHtml(string $content): void
    {
        if (!$this->currentSection)
        {
            throw new LayoutException('No Section selected. Please use set() methode before apply them to other.');
        }

        $node[] = [
            'type' => self::TYPE_HTML,
            'content' => $content,
        ];

        $this->apply($this->currentSection, $node);
    }

    /**
     * Apply the current section to another one.
     */
    public function append(string $alias): void
    {
        if (!$this->currentSection)
        {
            throw new LayoutException('No Section selected. Please use set() before apply them to other.');
        }

        if (!$this->sectionExists($alias))
        {
            throw new LayoutException("Section with name $alias do not exists.");
        }

        $this->apply($alias, [
            $this->currentSection => $this->removeSection($this->currentSection, $this->sections),
        ]);
    }

    public function parse(string $alias = null): string
    {
        if (!$this->sectionExists($alias, true))
        {
            throw new LayoutException("Section with name $alias do not exists or is not a root node.");
        }

        // Reset section html
        $this->children = [];

        // Build and return section
        $this->buildSection($this->sections[$alias ?? $this->currentSection]);

        return implode($this->blockSeparator, $this->children[0]);
    }

    public function parseAll(): string
    {
        $parsedSections = [];

        foreach (array_keys($this->sections) as $alias)
        {
            $parsedSections[] = $this->parse($alias);
        }

        return implode($this->blockSeparator, $parsedSections);
    }

    private function buildSection($section, int $level = 0): ?string
    {
        ++$level;

        // Parse all children
        if ($section['children'])
        {
            foreach ($section['children'] as $childrenSection)
            {
                if ($childContent = $this->buildSection($childrenSection, $level))
                {
                    $this->children[$level][] = $childContent;
                }
            }
        }

        // Return html content
        if (self::TYPE_HTML === $section['type'])
        {
            return $section['content'];
        }

        $parentLevel = $level - 1;

        if ($this->children[$level] ?? false)
        {
            // Get children content
            $html = implode($this->blockSeparator, $this->children[$level]);

            // Remove children content
            unset($this->children[$level]);

            // Build section with child content and add current level
            $this->children[$parentLevel][] = trim(str_replace(['<>', '</>'], '', vsprintf('<%s%s>%s%s%s</%s>', [
                $section['tag'],
                $this->parseAttributes($section['attributes']),
                $this->blockSeparator,
                $html,
                $this->blockSeparator,
                $section['tag'],
            ])));
        }

        return null;
    }

    /**
     * Apply nodes to sections.
     */
    private function apply(string $targetAlias, array $node, $sections = null): void
    {
        if (!$sections)
        {
            $sections = $this->sections;
        }

        foreach ($sections as $a => $section)
        {
            if (self::TYPE_SECTION !== $section['type'])
            {
                continue;
            }

            if ($a === $targetAlias)
            {
                $this->sections[$a]['children'] = array_merge($this->sections[$a]['children'] ?? [], $node);
                break;
            }

            if ($section['children'] ?? false)
            {
                $this->apply($targetAlias, $node, $section['children']);
            }
        }
    }

    /**
     * Remove a section and return they.
     */
    private function removeSection(string $alias, array &$sections): ?array
    {
        foreach ($sections as $a => $section)
        {
            if (self::TYPE_SECTION !== $section['type'])
            {
                continue;
            }

            if ($a === $alias)
            {
                $tmp = $section;
                unset($sections[$a]);

                return $tmp;
            }

            if ($section['children'] ?? false)
            {
                $this->removeSection($alias, $section['children']);
            }
        }

        return null;
    }

    /**
     * Check if a section exists.
     */
    private function sectionExists(string $alias, $rootOnly = false, array $sections = null): bool
    {
        if (!$sections)
        {
            $sections = $this->sections;
        }

        $bln = \in_array($alias, array_keys($sections), true);

        if (!$bln && !$rootOnly)
        {
            // Deep search
            foreach ($sections as $a => $section)
            {
                if ($a === $alias)
                {
                    return true;
                }

                if (self::TYPE_SECTION !== $section['type'])
                {
                    continue;
                }

                if ($section['children'])
                {
                    return $this->sectionExists($alias, $rootOnly, $section['children']);
                }
            }
        }

        return $bln;
    }

    /**
     * Return section attributes as string.
     */
    private function parseAttributes(array $attributes = null): string
    {
        if (!$attributes)
        {
            return '';
        }

        $arrAttr = [];

        foreach ($attributes as $key => $value)
        {
            $arrAttr[] = $key.'="'.$value.'"';
        }

        return ' '.implode(' ', $arrAttr);
    }
}
