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

namespace ContaoEstateManager\BackendRealEstateManagement\EventListener;

use Contao\CoreBundle\Exception\NoContentResponseException;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Input;
use Contao\System;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;

/**
 * @Hook("executePreActions")
 */
class ExecutePreActionsListener
{
    public function __invoke(string $action): void
    {
        if ('selectRealEstateSection' !== $action)
        {
            return;
        }

        /** @var AttributeBagInterface $objSessionBag */
        $objSessionBag = System::getContainer()->get('session')->getBag('contao_backend');

        $fs = $objSessionBag->get('be_real_estate_management');
        $fs['selection'] = Input::post('selection');

        $objSessionBag->set('be_real_estate_management', $fs);

        throw new NoContentResponseException();
    }
}
