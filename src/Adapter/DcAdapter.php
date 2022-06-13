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

namespace ContaoEstateManager\BackendRealEstateManagement\Adapter;

use Contao\Controller;
use Contao\DC_Table;
use Contao\Model;

/**
 * Adapter for DC_Table and the own backend module.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class DcAdapter extends DC_Table
{
    public function __construct()
    {
        Controller::loadDataContainer('tl_real_estate');

        parent::__construct('tl_real_estate');

        // Define values for parents save method
        $this->values[] = $this->intId;
        $this->procedure[] = 'id=?';
    }

    public function __get($strKey)
    {
        return parent::__get($strKey);
    }

    public function doReload(): bool
    {
        return !$this->noReload;
    }

    public function setModel(Model $objModel): void
    {
        $this->activeRecord = $objModel;
    }

    public function setWidget(string $name, $value): void
    {
        $this->strField = $name;
        $this->strInputName = $name;
        $this->varValue = $value;
    }

    public function getPalette(): string
    {
        return implode(',', array_keys($GLOBALS['TL_DCA'][$this->strTable]['fields']));
    }

    public function parse(): string
    {
        // Call load_callback
        if (\is_array($GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField]['load_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField]['load_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->varValue = $this->{$callback[0]}->{$callback[1]}($this->varValue, $this);
                }
                elseif (\is_callable($callback))
                {
                    $this->varValue = $callback($this->varValue, $this);
                }
            }
        }

        return $this->row();
    }
}
