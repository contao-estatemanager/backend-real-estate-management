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

$GLOBALS['CEM_BACKEND_FIELD_CONFIG'] = [
    'basics' => [
        'provider' => [
            'provider',
            'anbieternr',
            'contactPerson',
        ],
        'identification' => [
            ['column' => 'right'],
            'objektnrIntern',
            'objektnrExtern',
            'openimmoObid',
        ],
        'object' => [
            'nutzungsart',
            'objektart',
            'zimmerTyp',
            'wohnungTyp',
            'hausTyp',
            'grundstTyp',
            'bueroTyp',
            'handelTyp',
            'gastgewTyp',
            'hallenTyp',
            'landTyp',
            'parkenTyp',
            'sonstigeTyp',
            'freizeitTyp',
            'zinsTyp',
        ],
        'marketing' => [
            ['column' => 'right'],
            'vermarktungsartKauf',
            'vermarktungsartMietePacht',
            'vermarktungsartErbpacht',
            'vermarktungsartLeasing',
        ],
    ],
    'location' => [
        'address' => [
            'plz',
            'ort',
            'strasse',
            'hausnummer',
            'bundesland',
            'regionalerZusatz',
            'gemeindecode',
            'land',
            'objektadresseFreigeben',
        ],
        'distances' => [
            ['column' => 'right'],
            'distanzFlughafen',
            'distanzFernbahnhof',
            'distanzAutobahn',
            'distanzUsBahn',
            'distanzBus',
            'distanzKindergarten',
            'distanzGrundschule',
            'distanzHauptschule',
            'distanzRealschule',
            'distanzGesamtschule',
            'distanzGymnasium',
            'distanzZentrum',
            'distanzEinkaufsmoeglichkeiten',
            'distanzGaststaetten',
            'distanzSportStrand',
            'distanzSportSee',
            'distanzSportMeer',
            'distanzSportSkigebiet',
            'distanzSportSportanlagen',
            'distanzSportWandergebiete',
            'distanzSportNaherholung',
        ],
        'geo' => [
            'breitengrad',
            'laengengrad'
        ],
    ],
    'prices' => [
        'prices' => [
            'kaufpreis',
            'kaufpreisnetto',
            'kaufpreisbrutto',
            'warmmiete',
            'kaltmiete',
            'nettokaltmiete',
            'nettomieteprom2von',
            'nettomieteprom2bis',
            'pauschalmiete',
            'mietpreisProQm',
            'kaufpreisProQm',
            'richtpreis',
            'richtpreisprom2',
            'freitextPreis',
            'provisionspflichtig',
            'provisionTeilen',
            'provisionTeilenWert',
        ],
        'charges' => [
            ['column' => 'right'],
            'nebenkosten',
            'nebenkostenprom2von',
            'nebenkostenprom2bis',
            'heizkosten',
            'heizkostennetto',
            'heizkostenust',
            'heizkostenEnthalten',
            'zzgMehrwertsteuer',
            'mietzuschlaege',
        ],
        'groundlease' => [
            ['column' => 'right'],
            'laufzeit',
        ],
        'deposit' => [
            ['column' => 'right'],
            'kaution',
            'kautionText',
        ],
        'courtage' => [
            ['column' => 'right'],
            'innenCourtage',
            'innenCourtageMwst',
            'aussenCourtage',
            'aussenCourtageMwst',
            'courtageHinweis',
        ],
        'provision' => [
            ['column' => 'right'],
            'provisionnetto',
            'provisionbrutto',
            'provisionust',
        ],
        'investment' => [
            'nettorendite',
            'nettorenditeSoll',
            'nettorenditeIst',
            'mieteinnahmenIst',
            'mieteinnahmenIstPeriode',
            'mieteinnahmenSoll',
            'mieteinnahmenSollPeriode',
        ],
        'time' => [
            ['column' => 'right'],
            'preisZeitraumVon',
            'preisZeitraumBis',
            'preisZeiteinheit',
        ],
        'additional' => [
            'pacht',
            'erbpacht',
            'hausgeld',
            'abstand',
            'erschliessungskosten',
            'geschaeftsguthaben',
            'hauptmietzinsnetto',
            'hauptmietzinsust',
            'betriebskostennetto',
            'betriebskostenust',
            'evbnetto',
            'evbust',
            'gesamtmietenetto',
            'gesamtmieteust',
            'gesamtmietebrutto',
            'gesamtbelastungnetto',
            'gesamtbelastungust',
            'gesamtbelastungbrutto',
            'gesamtkostenprom2von',
            'gesamtkostenprom2bis',
            'monatlichekostennetto',
            'monatlichekostenust',
            'monatlichekostenbrutto',
            'ruecklagenetto',
            'ruecklageust',
            'sonstigekostennetto',
            'sonstigekostenust',
            'sonstigemietenetto',
            'sonstigemieteust',
            'summemietenetto',
            'summemieteust',
        ],
        'auction' => [
            ['column' => 'right'],
            'beginnAngebotsphase',
            'besichtigungstermin',
            'besichtigungstermin2',
            'beginnBietzeit',
            'endeBietzeit',
            'hoechstgebotZeigen',
            'mindestpreis',
        ],
        'forcedsale' => [
            ['column' => 'right'],
            'zwangsversteigerung',
            'aktenzeichen',
            'zvtermin',
            'zusatztermin',
            'amtsgericht',
            'verkehrswert',
            'versteigerungstermin',
        ],
        'currency' => [
            ['column' => 'right'],
            'waehrung',
        ],
    ],
    'areas' => [
        'areas' => [
            'wohnflaeche',
            'nutzflaeche',
            'gesamtflaeche',
            'grundstuecksflaeche',
            'ladenflaeche',
            'verkaufsflaeche',
            'freiflaeche',
            'bueroflaeche',
            'bueroteilflaeche',
            'fensterfront',
            'verwaltungsflaeche',
            'gastroflaeche',
            'gartenflaeche',
            'kellerflaeche',
            'teilbarAb'
        ],
        'quantity' => [
            ['column' => 'right'],
            'anzahlZimmer',
            'anzahlSchlafzimmer',
            'anzahlBadezimmer',
            'anzahlSepWc',
            'anzahlBalkone',
            'anzahlTerrassen',
            'anzahlLogia',
            'balkonTerrasseFlaeche',
            'anzahlWohnSchlafzimmer',
            'plaetzeGastraum',
            'anzahlBetten',
            'anzahlTagungsraeume',
        ],
        'area_other' => [
            ['column' => 'right'],
            'hallenhoehe',
            'dachbodenflaeche',
            'beheizbareFlaeche',
            'fensterfrontQm',
            'grundstuecksfront',
            'sonstflaeche',
        ],
        'area_plot' => [
            'grz',
            'gfz',
            'bmz',
            'bgf',
            'flur',
            'flurstueck',
            'gemarkung',
        ],
        'area_commerce' => [
            'flaechevon',
            'flaechebis'
        ],
        'area_investment' => [
            ['column' => 'right'],
            'vermietbareFlaeche',
            'anzahlWohneinheiten',
            'anzahlGewerbeeinheiten',
            'einliegerwohnung',
        ],
        'area_props' => [
            ['column' => 'right'],
            'kubatur',
            'ausnuetzungsziffer'
        ]
    ],
    'texts' => [
        'objTitle' => [
            'objekttitel',
        ],
        'objDesc' => [
            'objektbeschreibung',
        ],
        'objEquip' => [
            'ausstattBeschr',
        ],
        'objLocation' => [
            ['column' => 'right'],
            'lage',
        ],
        'objMisc' => [
            ['column' => 'right'],
            'sonstigeAngaben',
            'objektText',
            'dreizeiler',
        ],
    ],
    'details' => [
        'equip' => [
            'ausstattKategorie',
            'bad',
            'kueche',
            'boden',
            'heizungsart',
            'befeuerung',
            'fahrstuhlart',
            'moebliert',
            'ausrichtBalkonTerrasse',
            'serviceleistungen',
            'angeschlGastronomie',
            'sicherheitstechnik',
        ],
        'floor' => [
            ['column' => 'right'],
            'etage',
            'anzahlEtagen',
        ],
        'building' => [
            ['column' => 'right'],
            'unterkellert',
            'hochhaus',
            'denkmalgeschuetzt',
            'gewerblicheNutzung',
            'branchen',
            'alsFerien',
            'wbsSozialwohnung',
        ],
        'view' => [
            ['column' => 'right'],
            'ausblick',
            'lageImBau',
            'lageGebiet',
            'kartenMakro',
            'kartenMikro',
            'luftbildern',
            'virtuelletour',
        ],
        'internet' => [
            ['column' => 'right'],
            'kabelSatTv',
            'dvbt',
            'dvVerkabelung',
            'breitbandZugang',
            'breitbandGeschw',
            'breitbandArt',
            'umtsEmpfang',
            'kabelkanaele',
            'telefonFerienimmobilie',
        ],
        'details' => [
            ['column' => 'right'],
            'nichtraucher',
            'gaestewc',
            'haustiere',
            'raeumeVeraenderbar',
            'wgGeeignet',
            'abstellraum',
            'dachboden',
            'gartennutzung',
            'fahrradraum',
            'rolladen',
            'bibliothek',
            'klimatisiert',
            'seniorengerecht',
            'rollstuhlgerecht',
            'barrierefrei',
            'waschTrockenraum',
            'kamin',
            'sauna',
            'swimmingpool',
            'wintergarten',
            'rampe',
            'hebebuehne',
            'kran',
            'zulieferung',
            'gastterrasse',
            'kantineCafeteria',
            'teekueche',
            'brauereibindung',
            'sporteinrichtungen',
            'wellnessbereich',
        ],
        'project' => [
            ['column' => 'right'],
            'wohnungsnr',
            'gruppennummer',
        ],
        'extra' => [
            'geschlecht',
            'stromanschlusswert',
        ]
    ],
    'parking' => [
        'parking' => [
            'stellplatzart',
            'anzahlStellplaetze',
        ],
        'carport' => [
            'stpCarport',
            'stpCarportMietpreis',
            'stpCarportKaufpreis',
        ],
        'duplex' => [
            'stpDuplex',
            'stpDuplexMietpreis',
            'stpDuplexKaufpreis',
        ],
        'garage' => [
            ['column' => 'right'],
            'stpGarage',
            'stpGarageMietpreis',
            'stpGarageKaufpreis',
        ],
        'freiplatz' => [
            ['column' => 'right'],
            'stpFreiplatz',
            'stpFreiplatzMietpreis',
            'stpFreiplatzKaufpreis',
        ],
        'parkhaus' => [
            ['column' => 'right'],
            'stpParkhaus',
            'stpParkhausMietpreis',
            'stpParkhausKaufpreis',
        ],
        'tiefgarage' => [
            ['column' => 'right'],
            'stpTiefgarage',
            'stpTiefgarageMietpreis',
            'stpTiefgarageKaufpreis',
        ],
        'sonstige' => [
            'stpSonstige',
            'stpSonstigeMietpreis',
            'stpSonstigeKaufpreis',
            'stpSonstigePlatzart',
            'stpSonstigeBemerkung',
        ],
    ],
    'condition' => [
        'condition' => [
            'baujahr',
            'letztemodernisierung',
            'zustand',
            'alterAttr',
            'bebaubarNach',
            'erschliessung',
            'erschliessungUmfang',
            'bauzone',
            'altlasten',
        ],
        'energiepass' => [
            ['column' => 'right'],
            'energiepassEpart',
            'energiepassGueltigBis',
            'energiepassEnergieverbrauchkennwert',
            'energiepassEndenergiebedarf',
            'energiepassMitwarmwasser',
            'energiepassPrimaerenergietraeger',
            'energiepassStromwert',
            'energiepassWaermewert',
            'energiepassWertklasse',
            'energiepassBaujahr',
            'energiepassAusstelldatum',
            'energiepassJahrgang',
            'energiepassGebaeudeart',
            'energiepassEpasstext',
        ],
        'energiepassCountry' => [
            'energiepassHwbwert',
            'energiepassHwbklasse',
            'energiepassFgeewert',
            'energiepassFgeeklasse',
        ]
    ],
    'files' => [
        'images' => [
            'titleImageSRC',
            'imageSRC',
            'planImageSRC',
            'interiorViewImageSRC',
            'exteriorViewImageSRC',
            'mapViewImageSRC',
            'panoramaImageSRC',
            'epassSkalaImageSRC',
            'logoImageSRC',
            'qrImageSRC',
        ],
        'documents' => [
            ['column' => 'right'],
            'documents',
        ],
        'links' => [
            ['column' => 'right'],
            'links',
        ],
    ],
    'publishing' => [
        'web' => [
            'alias',
            'published',
        ],
        'seo' => [
            ['column' => 'right'],
            'metaTitle',
            'robots',
            'metaDescription',
            'serpPreview',
        ],
        'status' => [
            'zugang',
            'standVom',
            'verkaufstatus',
            'vermietet',
        ],
        'availability' => [
            'maxPersonen',
            'verfuegbarAb',
            'abdatum',
            'bisdatum',
            'minMietdauer',
            'maxMietdauer',
        ],
        'language' => [
            ['column' => 'right'],
            'sprache',
        ],
        'export' => [
            ['column' => 'right'],
            'aktivVon',
            'aktivBis',
            'anbieterobjekturl',
            'weitergabeGenerell',
            'weitergabePositiv',
            'weitergabeNegativ',
        ],
    ],
];
