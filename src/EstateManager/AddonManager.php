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

namespace ContaoEstateManager\BackendRealEstateManagement\EstateManager;

use Contao\Config;
use Contao\Environment;
use ContaoEstateManager\EstateManager;

class AddonManager
{
    /**
     * Bundle name.
     *
     * @var string
     */
    public static $bundle = 'EstateManagerBackendRealEstateManagement';

    /**
     * Package.
     *
     * @var string
     */
    public static $package = 'contao-estatemanager/backend-real-estate-management';

    /**
     * Addon config key.
     *
     * @var string
     */
    public static $key = 'addon_backend_real_estate_management_license';

    /**
     * Is initialized.
     *
     * @var bool
     */
    public static $initialized = false;

    /**
     * Is valid.
     *
     * @var bool
     */
    public static $valid = false;

    /**
     * Licenses.
     *
     * @var array
     */
    private static $licenses = [
        'e651e18e684353bb6c58d2905ed92ca3',
        'a0a53c9e13095de3e6002619203675fd',
        'c655e6185bd1d2112de70cfc7bc40cb2',
        'a5398e8ff35d73cd946b4ab69ec7b0de',
        'dae01f43a1aeaca71b8d2d19a95cce0c',
        'cf690cbf7be397da0a1f381a7c2a9a91',
        '732c00498a43e7b5bdf48dd099e61920',
        'e9896f324dcd532f29eee309e4884aea',
        'f930a681dfb9c1699216466a7b2786d6',
        '72b5950b346291bcf3c1a1e3f7334ca3',
        '0f3db443d565a173144f9d018034e632',
        '18c221539646b9d25c3e8cfac191b357',
        '1130e3cac3d8eaa47222a818c1f6db0c',
        '09c6c8bc49e2c8b46d107b595206bd74',
        'b3a80c28496c830163c0466310d485af',
        'b191e11bf3fd251055d8890041c4d3cb',
        '07757d4266888d8feaf686c97f347bb7',
        'd946a8f915dafc1c70a53bb92d07886b',
        'a77d21ed5b4a390b7f20f96b962f21e5',
        'f96181c223bf0a52108ca2eecd601f42',
        'bccdbd76ffaf64bec970bcdcdeb947cf',
        '01115ee149517d893b099da9fb49b5f4',
        'bc6bfaaeff040e8185f6ab98f9b92656',
        '526a96350c7034b97c1756bfab950189',
        '2c83bc0b8cdfbedb5028baaaab97c7ca',
        'f7144aeacd445b7037a1948a2fccd949',
        'ed4d386db00bc4c1223b534d472fe6ef',
        '65f05aa41ceaa2f34ce33286f332042e',
        '44b2d7c059b882fd529553f32cb83ab0',
        '2c6808cc0011fd6d785884f7ff0ad45e',
        'b698c04f2967e4689e2b00cf560fe8de',
        '08014b03a073b50d4bac69dffafec852',
        'f45ba5d2970ac3aff2d6ccb1adcebc79',
        '8a006671ad26d07948971d859657d521',
        'd6afd0cfb2c71d0d4bf913c891833b7d',
        '32a8b4f327dc5df3ef39b33ecab02aed',
        'f29f1c5ff6881accbf4ddab9e3a7ded0',
        'eed0e96111aed8fe3fa48614bbdcec51',
        '354568565bb162f874ee12facfa0c5d3',
        'ad1fc995a9ea2dfce0b49f1f463cc378',
        'b776c126c7de8a9f2d751313e28d085c',
        'c86f1acb209e012b24a8f194314bf5b4',
        'a72efe9188f4ca28c94dcc46a03c0293',
        'efd1977ff64a8268a9722ce305bd5820',
        '18545eab00ba6f86e5515dc3ebc1e69b',
        '754d91515a998ccff1466001cf7d616a',
        '01115ee149517d893b099da9fb49b5f4',
        'dd320cbc0c7c51e655f9fdedeefb0e61',
        'e7cec9017818c6ce786abd39e4a86028',
        '5bb68238b895a231b5518bc5629b3387',
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if (false !== strpos(Environment::get('requestUri'), '/contao/install'))
        {
            return true;
        }

        if (false === static::$initialized)
        {
            static::$valid = EstateManager::checkLicenses(Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }
}
