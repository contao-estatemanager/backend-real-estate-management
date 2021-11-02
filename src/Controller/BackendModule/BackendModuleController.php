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

namespace ContaoEstateManager\BackendRealEstateManagement\Controller\BackendModule;

use Contao\Ajax;
use Contao\Controller;
use Contao\Environment;
use Contao\Input;
use Contao\Message;
use Contao\System;
use ContaoEstateManager\BackendRealEstateManagement\Adapter\DcAdapter;
use ContaoEstateManager\BackendRealEstateManagement\EstateManager\AddonManager;
use ContaoEstateManager\BackendRealEstateManagement\LayoutBuilder;
use ContaoEstateManager\RealEstate;
use ContaoEstateManager\RealEstateModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment as TwigEnvironment;

/**
 * Real estate edit module.
 *
 * @Route("/contao/realestate/edit/{id}", name=BackendModuleController::class, defaults={"_scope": "backend"})
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class BackendModuleController extends AbstractController
{
    private int $intId;
    private string $strTable = 'tl_real_estate';

    private DcAdapter $adapter;
    private RealEstateModel $objRealEstate;

    private TwigEnvironment $twig;
    private TranslatorInterface $translator;

    public function __construct(TwigEnvironment $twig, TranslatorInterface $translator)
    {
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function __invoke($id): Response
    {
        Input::setGet('id', $id);

        $this->intId = (int) $id;
        $this->objRealEstate = RealEstateModel::findByIdOrAlias($id);

        $this->adapter = new DcAdapter();
        $this->adapter->setModel($this->objRealEstate);

        // Handle ajax requests
        if ($_POST && Environment::get('isAjaxRequest'))
        {
            $action = Input::post('action');
            $objAjax = new Ajax($action);

            if ('selectRealEstateSection' === $action)
            {
                $objAjax->executePreActions();
            }

            $objAjax->executePostActions($this->adapter);
        }

        // Load language files
        System::loadLanguageFile('backend_real_estate_management');
        System::loadLanguageFile($this->strTable);

        // Check if extension is valid
        if (!($isValid = AddonManager::valid()))
        {
            Message::addInfo($this->translator->trans('backend_real_estate_management.invalid', [], 'contao_default'));
        }

        // Parse tabs and widgets by config
        $htmlContent = $this->parse($GLOBALS['CEM_BACKEND_FIELD_CONFIG']);

        if ($this->adapter->doReload() && Input::post('FORM_SUBMIT') === $this->strTable)
        {
            Controller::reload();
        }

        // Get real estate object
        $realEstate = new RealEstate($this->objRealEstate);

        // Render template
        return new Response($this->twig->render(
            '@EstateManagerBackendRealEstateManagement/be_real_estate_edit.html.twig',
            [
                'head' => [
                    'title' => $this->translator->trans('backend_real_estate_management.title', [$id], 'contao_default'),
                    'subtitle' => $realEstate->title,
                    'image' => $realEstate->generateMainImage([50, 50]),
                    'message' => Message::generate(),
                    'classicLink' => '/contao?do=real_estate&act=edit&id='.$id.'&rt='.REQUEST_TOKEN,
                    'classicLabel' => $this->translator->trans('backend_real_estate_management.label_classic_link', [], 'contao_default'),
                ],
                'form' => [
                    'id' => $id,
                    'rt' => REQUEST_TOKEN,
                    'palette' => $this->adapter->getPalette(),
                    'label' => $this->translator->trans('backend_real_estate_management.label_submit', [], 'contao_default'),
                    'content' => $htmlContent,
                ],
                'valid' => $isValid,
            ]
        ));
    }

    private function parse($palette): string
    {
        $layout = new LayoutBuilder();

        $layout->addSection('inputs');
        $layout->addSection('navigation', 'nav');
        $layout->addSection('tabs', 'div', [
            'class' => 'tab_content',
        ]);

        $objSession = System::getContainer()->get('session')->getBag('contao_backend');
        $arrSession = $objSession->get('be_real_estate_management');

        $level = 0;

        foreach ($palette as $tabName => $fieldsets)
        {
            $event = sprintf('onclick="Backend.getScrollOffset(); new Request.Contao().post({\'action\':\'selectRealEstateSection\', \'id\':\'%s\', \'selection\':\'%s\', \'REQUEST_TOKEN\':\'%s\'});"', $this->intId, $tabName, REQUEST_TOKEN);
            $isSelected = $arrSession['selection'] ?? null ? ($arrSession['selection'] === $tabName) : (0 === $level);

            $layout->set('inputs')->addHtml('<input type="radio" name="real_estate_tabs" class="tab_input" id="tab_'.$level.'" '.($isSelected ? 'checked' : '').'/>');
            $layout->set('navigation')->addHtml('<label for="tab_'.$level.'" id="label_'.$level.'" class="'.$tabName.'" '.$event.'>'.$this->translator->trans('backend_real_estate_management.tab_'.$tabName, [], 'contao_default').'</label>');

            // Create sections
            $layout->addSection('tab_'.$level, 'div', [
                'id' => 'cont_'.$level,
                'class' => 'tab_cont',
            ]);

            $layout->addSection('left_'.$level, 'div', ['class' => 'left']);
            $layout->addSection('right_'.$level, 'div', ['class' => 'right']);

            foreach ($fieldsets as $legend => $fieldset)
            {
                $attributes = null;
                $columnLeft = null;
                $columnRight = null;

                foreach ($fieldset as $fieldName)
                {
                    if (\is_array($fieldName))
                    {
                        $attributes = $fieldName;
                        continue;
                    }

                    if ($GLOBALS['TL_DCA'][$this->strTable]['fields'][$fieldName] ?? null)
                    {
                        // Reset field exclude
                        $GLOBALS['TL_DCA'][$this->strTable]['fields'][$fieldName]['exclude'] = false;

                        // Set widget
                        $this->adapter->setWidget($fieldName, $this->objRealEstate->{$fieldName});

                        // Get parsed widget
                        $widget = $this->adapter->parse();

                        switch ($attributes['column'] ?? 'left')
                        {
                            case 'left':
                                $columnLeft[] = $widget;
                                break;

                            case 'right':
                                $columnRight[] = $widget;
                                break;
                        }
                    }
                }

                if ($columnLeft || $columnRight)
                {
                    $layout->addSection('fieldset_'.$legend, 'fieldset');
                    $layout->addHtml('<legend>'.$this->translator->trans('backend_real_estate_management.legend_'.$legend, [], 'contao_default').'</legend>');

                    if ($columnLeft)
                    {
                        $layout->addHtml(implode('', $columnLeft));
                        $layout->append('left_'.$level);
                    }

                    if ($columnRight)
                    {
                        $layout->addHtml(implode('', $columnRight));
                        $layout->append('right_'.$level);
                    }
                }
            }

            $layout->set('left_'.$level)->append('tab_'.$level);
            $layout->set('right_'.$level)->append('tab_'.$level);
            $layout->set('tab_'.$level)->append('tabs');

            ++$level;
        }

        return $layout->parseAll();
    }
}
