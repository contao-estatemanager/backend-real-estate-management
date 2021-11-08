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

use Contao\BackendUser;
use Contao\Environment;
use Contao\StringUtil;
use Contao\Image;

$GLOBALS['TL_DCA']['tl_real_estate']['list']['operations']['edit']['button_callback'] = static function(array $row, string $href, string $label, string $title, string $icon, string $attributes)
{
    $user = BackendUser::getInstance();
    return $user->canEditFieldsOf('tl_real_estate') ? '<a href="/contao/realestate/edit/'.$row['id'].'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
};

if (false !== strpos(Environment::get('requestUri'), '/contao/realestate/edit/'))
{
    // Load backend css / js
    $GLOBALS['TL_CSS'][] = 'bundles/estatemanagerbackendrealestatemanagement/css/backend.css';
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/estatemanagerbackendrealestatemanagement/js/backend.js';

    // Helper functions (field dependencies)
    $marketingBuy = static function ($fieldOrNumber, $objModel, &$dependentFields) {
        $dependentFields[] = 'vermarktungsartKauf';
        $dependentFields[] = 'vermarktungsartErbpacht';

        if (is_string($fieldOrNumber))
        {
            return ((bool) $objModel->vermarktungsartKauf || (bool) $objModel->vermarktungsartErbpacht) && 1 === $objModel->{$fieldOrNumber};
        }

        return (bool) $objModel->vermarktungsartKauf || (bool) $objModel->vermarktungsartErbpacht;
    };

    $marketingRent = static function ($fieldOrNumber, $objModel, &$dependentFields) {
        $dependentFields[] = 'vermarktungsartMietePacht';
        $dependentFields[] = 'vermarktungsartLeasing';

        if (is_string($fieldOrNumber))
        {
            return ((bool) $objModel->vermarktungsartMietePacht || (bool) $objModel->vermarktungsartLeasing) && 1 === $objModel->{$fieldOrNumber};
        }

        return (bool) $objModel->vermarktungsartMietePacht || (bool) $objModel->vermarktungsartLeasing;
    };

    // Remove class 'clr' from all fields
    foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields'] as $fieldName => $fieldOptions)
    {
        if (($fieldOptions['eval']['tl_class'] ?? false) && false !== strpos($fieldOptions['eval']['tl_class'], 'clr'))
        {
            $GLOBALS['TL_DCA']['tl_real_estate']['fields'][$fieldName]['eval']['tl_class'] = str_replace('clr', '', $fieldOptions['eval']['tl_class']);
        }
    }

    // Field dependencies
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['zimmerTyp']['dependsOn'] = ['objektart' => 'zimmer'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['wohnungTyp']['dependsOn'] = ['objektart' => 'wohnung'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['hausTyp']['dependsOn'] = ['objektart' => 'haus'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['grundstTyp']['dependsOn'] = ['objektart' => 'grundstueck'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['bueroTyp']['dependsOn'] = ['objektart' => 'buero_praxen'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['handelTyp']['dependsOn'] = ['objektart' => 'einzelhandel'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['gastgewTyp']['dependsOn'] = ['objektart' => 'gastgewerbe'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['hallenTyp']['dependsOn'] = ['objektart' => 'hallen_lager_prod'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['parkenTyp']['dependsOn'] = ['objektart' => 'parken'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['sonstigeTyp']['dependsOn'] = ['objektart' => 'sonstige'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['zinsTyp']['dependsOn'] = ['objektart' => 'zinshaus_renditeobjekt'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['landTyp']['dependsOn'] = ['objektart' => 'land_und_forstwirtschaft'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['freizeitTyp']['dependsOn'] = ['objektart' => 'freizeitimmobilie_gewerblich'];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['breitbandArt']['dependsOn'] = ['breitbandZugang' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['breitbandGeschw']['dependsOn'] = ['breitbandZugang' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['weitergabePositiv']['dependsOn'] = ['weitergabeGenerell' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['weitergabeNegativ']['dependsOn'] = ['weitergabeGenerell' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['verkaufstatus']['dependsOn'] = ['vermarktungsartKauf' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['vermietet']['dependsOn'] = ['vermarktungsartMietePacht' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['laufzeit']['dependsOn'] = ['vermarktungsartErbpacht' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaufpreis']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaufpreisAufAnfrage']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaufpreisnetto']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaufpreisbrutto']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaufpreisProQm']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['provisionspflichtig']['dependsOn'] = [$marketingBuy];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['provisionTeilen']['dependsOn'] = ['provisionspflichtig' => $marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['provisionTeilenWert']['dependsOn'] = ['provisionTeilen' => $marketingBuy];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['innenCourtage']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['innenCourtageMwst']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['aussenCourtage']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['aussenCourtageMwst']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['courtageHinweis']['dependsOn'] = [$marketingBuy];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['nettorendite']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['nettorenditeSoll']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['nettorenditeIst']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['mieteinnahmenIst']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['mieteinnahmenIstPeriode']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['mieteinnahmenSoll']['dependsOn'] = [$marketingBuy];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['mieteinnahmenSollPeriode']['dependsOn'] = [$marketingBuy];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['warmmiete']['dependsOn'] = [$marketingRent];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['kaltmiete']['dependsOn'] = [$marketingRent];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['nettokaltmiete']['dependsOn'] = [$marketingRent];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['mietpreisProQm']['dependsOn'] = [$marketingRent];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['energiepassEnergieverbrauchkennwert']['dependsOn'] = ['energiepassEpart' => 'verbrauch'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['energiepassMitwarmwasser']['dependsOn'] = ['energiepassEpart' => 'verbrauch'];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['energiepassEndenergiebedarf']['dependsOn'] = ['energiepassEpart' => 'bedarf'];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['breitbandGeschw']['dependsOn'] = ['breitbandZugang' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['breitbandArt']['dependsOn'] = ['breitbandZugang' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['branchen']['dependsOn'] = ['gewerblicheNutzung' => 1];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['aktenzeichen']['dependsOn'] = ['zwangsversteigerung' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['zvtermin']['dependsOn'] = ['zwangsversteigerung' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['zusatztermin']['dependsOn'] = ['zwangsversteigerung' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['amtsgericht']['dependsOn'] = ['zwangsversteigerung' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['verkehrswert']['dependsOn'] = ['zwangsversteigerung' => 1];
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['versteigerungstermin']['dependsOn'] = ['zwangsversteigerung' => 1];

    // Styles
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['weitergabePositiv']['eval']['tl_class'] .= ' clr';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['objekttitel']['eval']['tl_class'] .= ' long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['alias']['eval']['tl_class'] .= ' long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['metaDescription']['eval']['tl_class'] .= ' clr';

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['bad']['eval']['tl_class'] = 'clr long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['angeschlGastronomie']['eval']['tl_class'] = 'clr long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['sicherheitstechnik']['eval']['tl_class'] = 'clr long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['ausstattKategorie']['eval']['tl_class'] = 'long';
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['unterkellert']['eval']['tl_class'] = 'long';


    // Clear checkbox widgets
    $arrCheckboxes = ['wbsSozialwohnung','kartenMakro','kartenMikro','luftbildern','virtuelletour','hochhaus','denkmalgeschuetzt','gewerblicheNutzung','branchen','alsFerien','kabelSatTv','dvbt','dvVerkabelung','breitbandZugang','umtsEmpfang','kabelkanaele','telefonFerienimmobilie','nichtraucher','gaestewc','haustiere','raeumeVeraenderbar','wgGeeignet','abstellraum','dachboden','gartennutzung','fahrradraum','rolladen','bibliothek','klimatisiert','seniorengerecht','rollstuhlgerecht','barrierefrei','waschTrockenraum','kamin','sauna','swimmingpool','wintergarten','rampe','hebebuehne','kran','zulieferung','gastterrasse','kantineCafeteria','teekueche','brauereibindung','sporteinrichtungen','wellnessbereich'];

    foreach ($arrCheckboxes as $field)
    {
        $GLOBALS['TL_DCA']['tl_real_estate']['fields'][$field]['eval']['tl_class'] = 'clr';
    }

    // Reset trigger (use dependsOn only)
    unset($GLOBALS['TL_DCA']['tl_real_estate']['subpalettes'], $GLOBALS['TL_DCA']['tl_real_estate']['palettes']['__selector__']);
}
