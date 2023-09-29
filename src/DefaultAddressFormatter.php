<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use BinSoul\Common\I18n\Data\StateData;

/**
 * Provides a default implementation of the {@see AddressFormatter} interface.
 */
class DefaultAddressFormatter implements AddressFormatter
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var mixed[][]
     */
    private static $formats = [
        /*
         * Source: https://chromium-i18n.appspot.com/ssl-address
         * Copyright 2021 Google LLC. This data is licensed by Google under the CC-BY 4.0 (https://creativecommons.org/licenses/by/4.0/) license.
         * Data was converted into a suitable format.
         *
         * fmt, require, upper, locality_name_type, sublocality_name_type, state_name_type, zip_name_type, zip
         */
        'AC' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, 'ASCN 1ZZ'],
        'AD' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, 'AD[1-7]0\d'],
        'AE' => ['%N%n%O%n%A%n%S', 'AS', null, null, null, null, null],
        'AF' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, '\d{4}'],
        'AI' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, '(?:AI-)?2640'],
        'AL' => ['%N%n%O%n%A%n%Z%n%C', null, null, null, null, null, '\d{4}'],
        'AM' => ['%N%n%O%n%A%n%Z%n%C%n%S', null, null, null, null, null, '(?:37)?\d{4}'],
        'AR' => ['%N%n%O%n%A%n%Z %C%n%S', null, 'ACZ', null, null, null, '((?:[A-HJ-NP-Z])?\d{4})([A-Z]{3})?'],
        'AS' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(96799)(?:[ \-](\d{4}))?'],
        'AT' => ['%O%n%N%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{4}'],
        'AU' => ['%O%n%N%n%A%n%C %S %Z', 'ACSZ', 'CS', 'suburb', null, null, '\d{4}'],
        'AX' => ['%O%n%N%n%A%nAX-%Z %C%nÅLAND', 'ACZ', null, null, null, null, '22\d{3}'],
        'AZ' => ['%N%n%O%n%A%nAZ %Z %C', null, null, null, null, null, '\d{4}'],
        'BA' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'BB' => ['%N%n%O%n%A%n%C, %S %Z', null, null, null, null, null, 'BB\d{5}'],
        'BD' => ['%N%n%O%n%A%n%C - %Z', null, null, null, null, null, '\d{4}'],
        'BE' => ['%O%n%N%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{4}'],
        'BF' => ['%N%n%O%n%A%n%C %X', null, null, null, null, null, null],
        'BG' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'BH' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '(?:\d|1[0-2])\d{2}'],
        'BL' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78][01]\d{2}'],
        'BM' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '[A-Z]{2} ?[A-Z0-9]{2}'],
        'BN' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '[A-Z]{2} ?\d{4}'],
        'BR' => ['%O%n%N%n%A%n%D%n%C-%S%n%Z', 'ASCZ', 'CS', null, 'neighborhood', null, '\d{5}-?\d{3}'],
        'BS' => ['%N%n%O%n%A%n%C, %S', null, null, null, null, null, null],
        'BT' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}'],
        'BY' => ['%O%n%N%n%A%n%Z, %C%n%S', null, null, null, null, null, '\d{6}'],
        'CA' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOSZ', null, null, null, '[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z] ?((\d[ABCEGHJ-NPRSTV-Z]\d)|$)'],
        'CC' => ['%O%n%N%n%A%n%C %S %Z', null, 'CS', null, null, null, '6799'],
        'CH' => ['%O%n%N%n%A%nCH-%Z %C', 'ACZ', null, null, null, null, '\d{4}'],
        'CI' => ['%N%n%O%n%X %A %C %X', null, null, null, null, null, null],
        'CL' => ['%N%n%O%n%A%n%Z %C%n%S', null, null, null, null, null, '\d{7}'],
        'CN' => ['%Z%n%S%C%D%n%A%n%O%n%N', 'ACSZ', 'S', null, 'district', null, '\d{6}'],
        'CO' => ['%N%n%O%n%A%n%C, %S, %Z', 'AS', null, null, null, null, '\d{6}'],
        'CR' => ['%N%n%O%n%A%n%S, %C%n%Z', 'ACS', null, null, null, null, '\d{4,5}|\d{3}-\d{4}'],
        'CU' => ['%N%n%O%n%A%n%C %S%n%Z', null, null, null, null, null, '\d{5}'],
        'CV' => ['%N%n%O%n%A%n%Z %C%n%S', null, null, null, null, null, '\d{4}'],
        'CX' => ['%O%n%N%n%A%n%C %S %Z', null, 'CS', null, null, null, '6798'],
        'CY' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'CZ' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{3} ?\d{2}'],
        'DE' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{5}'],
        'DK' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{4}'],
        'DO' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'DZ' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'EC' => ['%N%n%O%n%A%n%Z%n%C', null, 'CZ', null, null, null, '\d{6}'],
        'EE' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{5}'],
        'EG' => ['%N%n%O%n%A%n%C%n%S%n%Z', null, null, null, null, null, '\d{5}'],
        'EH' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'ES' => ['%N%n%O%n%A%n%Z %C %S', 'ACSZ', 'CS', null, null, null, '\d{5}'],
        'ET' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'FI' => ['%O%n%N%n%A%nFI-%Z %C', 'ACZ', null, null, null, null, '\d{5}'],
        'FK' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'FIQQ 1ZZ'],
        'FM' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(9694[1-4])(?:[ \-](\d{4}))?'],
        'FO' => ['%N%n%O%n%A%nFO%Z %C', null, null, null, null, null, '\d{3}'],
        'FR' => ['%O%n%N%n%A%n%Z %C', 'ACZ', 'CX', null, null, null, '\d{2} ?\d{3}'],
        'GB' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', 'post_town', null, null, 'GIR ?0AA|(?:(?:AB|AL|B|BA|BB|BD|BF|BH|BL|BN|BR|BS|BT|BX|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(?:\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}))|BFPO ?\d{1,4}'],
        'GE' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'GF' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78]3\d{2}'],
        'GG' => ['%N%n%O%n%A%n%C%nGUERNSEY%n%Z', 'ACZ', 'CZ', null, null, null, 'GY\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}'],
        'GI' => ['%N%n%O%n%A%nGIBRALTAR%n%Z', 'A', null, null, null, null, 'GX11 1AA'],
        'GL' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '39\d{2}'],
        'GN' => ['%N%n%O%n%Z %A %C', null, null, null, null, null, '\d{3}'],
        'GP' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78][01]\d{2}'],
        'GR' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{3} ?\d{2}'],
        'GS' => ['%N%n%O%n%A%n%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'SIQQ 1ZZ'],
        'GT' => ['%N%n%O%n%A%n%Z- %C', null, null, null, null, null, '\d{5}'],
        'GU' => ['%N%n%O%n%A%n%C %Z', 'ACZ', 'ACNO', null, null, 'zip', '(969(?:[12]\d|3[12]))(?:[ \-](\d{4}))?'],
        'GW' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'HK' => ['%S%n%C%n%A%n%O%n%N', 'AS', 'S', 'district', null, null, null],
        'HM' => ['%O%n%N%n%A%n%C %S %Z', null, 'CS', null, null, null, '\d{4}'],
        'HN' => ['%N%n%O%n%A%n%C, %S%n%Z', 'ACS', null, null, null, null, '\d{5}'],
        'HR' => ['%N%n%O%n%A%nHR-%Z %C', null, null, null, null, null, '\d{5}'],
        'HT' => ['%N%n%O%n%A%nHT%Z %C', null, null, null, null, null, '\d{4}'],
        'HU' => ['%N%n%O%n%C%n%A%n%Z', 'ACZ', 'ACNO', null, null, null, '\d{4}'],
        'ID' => ['%N%n%O%n%A%n%C%n%S %Z', 'AS', null, null, null, null, '\d{5}'],
        'IE' => ['%N%n%O%n%A%n%D%n%C%n%S%n%Z', null, null, null, 'townland', 'eircode', '[\dA-Z]{3} ?[\dA-Z]{4}'],
        'IL' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}(?:\d{2})?'],
        'IM' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'IM\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}'],
        'IN' => ['%N%n%O%n%A%n%C %Z%n%S', 'ACSZ', null, null, null, 'pin', '\d{6}'],
        'IO' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'BBND 1ZZ'],
        'IQ' => ['%O%n%N%n%A%n%C, %S%n%Z', 'ACS', 'CS', null, null, null, '\d{5}'],
        'IR' => ['%O%n%N%n%S%n%C, %D%n%A%n%Z', null, null, null, 'neighborhood', null, '\d{5}-?\d{5}'],
        'IS' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{3}'],
        'IT' => ['%N%n%O%n%A%n%Z %C %S', 'ACSZ', 'CS', null, null, null, '\d{5}'],
        'JE' => ['%N%n%O%n%A%n%C%nJERSEY%n%Z', 'ACZ', 'CZ', null, null, null, 'JE\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}'],
        'JM' => ['%N%n%O%n%A%n%C%n%S %X', 'ACS', null, null, null, null, null],
        'JO' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}'],
        'JP' => ['〒%Z%S%n%C%n%D%n%A%n%O%n%N', 'ACSZ', 'S', null, null, null, '\d{3}-?\d{4}'],
        'KE' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, '\d{5}'],
        'KG' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{6}'],
        'KH' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5,6}'],
        'KI' => ['%N%n%O%n%A%n%S%n%C', null, 'ACNOS', null, null, null, null],
        'KN' => ['%N%n%O%n%A%n%C, %S', 'ACS', null, null, null, null, null],
        'KP' => ['%Z%n%S%n%C%n%A%n%O%n%N', null, null, null, null, null, null],
        'KR' => ['%S %C%D%n%A%n%O%n%N%n%Z', 'ACSZ', 'Z', null, 'district', null, '\d{5}'],
        'KW' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'KY' => ['%N%n%O%n%A%n%S %Z', 'AS', null, null, null, null, 'KY\d-\d{4}'],
        'KZ' => ['%Z%n%S%n%C%n%A%n%O%n%N', null, null, null, null, null, '\d{6}'],
        'LA' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'LB' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '(?:\d{4})(?: ?(?:\d{4}))?'],
        'LI' => ['%O%n%N%n%A%nFL-%Z %C', 'ACZ', null, null, null, null, '948[5-9]|949[0-8]'],
        'LK' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, '\d{5}'],
        'LR' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'LS' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{3}'],
        'LT' => ['%O%n%N%n%A%nLT-%Z %C', 'ACZ', null, null, null, null, '\d{5}'],
        'LU' => ['%O%n%N%n%A%nL-%Z %C', 'ACZ', null, null, null, null, '\d{4}'],
        'LV' => ['%N%n%O%n%A%n%C, %Z', 'ACZ', null, null, null, null, 'LV-\d{4}'],
        'MA' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'MC' => ['%N%n%O%n%A%nMC-%Z %C %X', null, null, null, null, null, '980\d{2}'],
        'MD' => ['%N%n%O%n%A%nMD-%Z %C', null, null, null, null, null, '\d{4}'],
        'ME' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '8\d{4}'],
        'MF' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78][01]\d{2}'],
        'MG' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{3}'],
        'MH' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(969[67]\d)(?:[ \-](\d{4}))?'],
        'MK' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'MM' => ['%N%n%O%n%A%n%C, %Z', null, null, null, null, null, '\d{5}'],
        'MN' => ['%N%n%O%n%A%n%C%n%S %Z', null, null, null, null, null, '\d{5}'],
        'MO' => ['%A%n%O%n%N', 'A', null, null, null, null, null],
        'MP' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(9695[012])(?:[ \-](\d{4}))?'],
        'MQ' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78]2\d{2}'],
        'MT' => ['%N%n%O%n%A%n%C %Z', null, 'CZ', null, null, null, '[A-Z]{3} ?\d{2,4}'],
        'MU' => ['%N%n%O%n%A%n%Z%n%C', null, 'CZ', null, null, null, '\d{3}(?:\d{2}|[A-Z]{2}\d{3})'],
        'MV' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}'],
        'MW' => ['%N%n%O%n%A%n%C %X', null, null, null, null, null, null],
        'MX' => ['%N%n%O%n%A%n%D%n%Z %C, %S', 'ACSZ', 'CSZ', null, 'neighborhood', null, '\d{5}'],
        'MY' => ['%N%n%O%n%A%n%D%n%Z %C%n%S', 'ACZ', 'CS', null, 'village_township', null, '\d{5}'],
        'MZ' => ['%N%n%O%n%A%n%Z %C%S', null, null, null, null, null, '\d{4}'],
        'NA' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, '\d{5}'],
        'NC' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '988\d{2}'],
        'NE' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'NF' => ['%O%n%N%n%A%n%C %S %Z', null, 'CS', null, null, null, '2899'],
        'NG' => ['%N%n%O%n%A%n%D%n%C %Z%n%S', null, 'CS', null, null, null, '\d{6}'],
        'NI' => ['%N%n%O%n%A%n%Z%n%C, %S', null, 'CS', null, null, null, '\d{5}'],
        'NL' => ['%O%n%N%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{4} ?[A-Z]{2}'],
        'NO' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, 'post_town', null, null, '\d{4}'],
        'NP' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}'],
        'NR' => ['%N%n%O%n%A%n%S', 'AS', null, null, null, null, null],
        'NZ' => ['%N%n%O%n%A%n%D%n%C %Z', 'ACZ', null, null, null, null, '\d{4}'],
        'OM' => ['%N%n%O%n%A%n%Z%n%C', null, null, null, null, null, '(?:PC )?\d{3}'],
        'PA' => ['%N%n%O%n%A%n%C%n%S', null, 'CS', null, null, null, null],
        'PE' => ['%N%n%O%n%A%n%C %Z%n%S', null, null, 'district', null, null, '(?:LIMA \d{1,2}|CALLAO 0?\d)|[0-2]\d{4}'],
        'PF' => ['%N%n%O%n%A%n%Z %C %S', 'ACSZ', 'CS', null, null, null, '987\d{2}'],
        'PG' => ['%N%n%O%n%A%n%C %Z %S', 'ACS', null, null, null, null, '\d{3}'],
        'PH' => ['%N%n%O%n%A%n%D, %C%n%Z %S', null, null, null, null, null, '\d{4}'],
        'PK' => ['%N%n%O%n%A%n%C-%Z', null, null, null, null, null, '\d{5}'],
        'PL' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{2}-\d{3}'],
        'PM' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78]5\d{2}'],
        'PN' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'PCRN 1ZZ'],
        'PR' => ['%N%n%O%n%A%n%C PR %Z', 'ACZ', 'ACNO', null, null, 'zip', '(00[679]\d{2})(?:[ \-](\d{4}))?'],
        'PT' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{4}-\d{3}'],
        'PW' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(969(?:39|40))(?:[ \-](\d{4}))?'],
        'PY' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'RE' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '9[78]4\d{2}'],
        'RO' => ['%N%n%O%n%A%n%Z %C', 'ACZ', 'AC', null, null, null, '\d{6}'],
        'RS' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5,6}'],
        'RU' => ['%N%n%O%n%A%n%C%n%S%n%Z', 'ACSZ', 'AC', null, null, null, '\d{6}'],
        'SA' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, '\d{5}'],
        'SC' => ['%N%n%O%n%A%n%C%n%S', null, 'S', null, null, null, null],
        'SD' => ['%N%n%O%n%A%n%C%n%Z', null, null, 'district', null, null, '\d{5}'],
        'SE' => ['%O%n%N%n%A%nSE-%Z %C', 'ACZ', null, 'post_town', null, null, '\d{3} ?\d{2}'],
        'SG' => ['%N%n%O%n%A%nSINGAPORE %Z', 'AZ', null, null, null, null, '\d{6}'],
        'SH' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, '(?:ASCN|STHL) 1ZZ'],
        'SI' => ['%N%n%O%n%A%nSI-%Z %C', null, null, null, null, null, '\d{4}'],
        'SJ' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, 'post_town', null, null, '\d{4}'],
        'SK' => ['%N%n%O%n%A%n%Z %C', 'ACZ', null, null, null, null, '\d{3} ?\d{2}'],
        'SM' => ['%N%n%O%n%A%n%Z %C', 'AZ', null, null, null, null, '4789\d'],
        'SN' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
        'SO' => ['%N%n%O%n%A%n%C, %S %Z', 'ACS', 'ACS', null, null, null, '[A-Z]{2} ?\d{5}'],
        'SR' => ['%N%n%O%n%A%n%C%n%S', null, 'AS', null, null, null, null],
        'SV' => ['%N%n%O%n%A%n%Z-%C%n%S', 'ACS', 'CSZ', null, null, null, 'CP [1-3][1-7][0-2]\d'],
        'SZ' => ['%N%n%O%n%A%n%C%n%Z', null, 'ACZ', null, null, null, '[HLMS]\d{3}'],
        'TA' => ['%N%n%O%n%A%n%C%n%Z', null, null, null, null, null, 'TDCU 1ZZ'],
        'TC' => ['%N%n%O%n%A%n%C%n%Z', 'ACZ', 'CZ', null, null, null, 'TKCA 1ZZ'],
        'TH' => ['%N%n%O%n%A%n%D %C%n%S %Z', null, 'S', null, null, null, '\d{5}'],
        'TJ' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{6}'],
        'TM' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{6}'],
        'TN' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4}'],
        'TR' => ['%N%n%O%n%A%n%Z %C/%S', 'ACZ', null, 'district', null, null, '\d{5}'],
        'TV' => ['%N%n%O%n%A%n%C%n%S', null, 'ACS', null, null, null, null],
        'TW' => ['%Z%n%S%C%n%A%n%O%n%N', 'ACSZ', null, null, null, null, '\d{3}(?:\d{2,3})?'],
        'TZ' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{4,5}'],
        'UA' => ['%N%n%O%n%A%n%C%n%S%n%Z', 'ACZ', null, null, null, null, '\d{5}'],
        'UM' => ['%N%n%O%n%A%n%C %S %Z', 'ACS', 'ACNOS', null, null, 'zip', '96898'],
        'US' => ['%N%n%O%n%A%n%C, %S %Z', 'ACSZ', 'CS', null, null, 'zip', '(\d{5})(?:[ \-](\d{4}))?'],
        'UY' => ['%N%n%O%n%A%n%Z %C %S', null, 'CS', null, null, null, '\d{5}'],
        'UZ' => ['%N%n%O%n%A%n%Z %C%n%S', null, 'CS', null, null, null, '\d{6}'],
        'VA' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '00120'],
        'VC' => ['%N%n%O%n%A%n%C %Z', null, null, null, null, null, 'VC\d{4}'],
        'VE' => ['%N%n%O%n%A%n%C %Z, %S', 'ACS', 'CS', null, null, null, '\d{4}'],
        'VG' => ['%N%n%O%n%A%n%C%n%Z', 'A', null, null, null, null, 'VG\d{4}'],
        'VI' => ['%N%n%O%n%A%n%C %S %Z', 'ACSZ', 'ACNOS', null, null, 'zip', '(008(?:(?:[0-4]\d)|(?:5[01])))(?:[ \-](\d{4}))?'],
        'VN' => ['%N%n%O%n%A%n%C%n%S %Z', null, null, null, null, null, '\d{5}\d?'],
        'WF' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '986\d{2}'],
        'XK' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '[1-7]\d{4}'],
        'YT' => ['%O%n%N%n%A%n%Z %C %X', 'ACZ', 'ACX', null, null, null, '976\d{2}'],
        'ZA' => ['%N%n%O%n%A%n%D%n%C%n%Z', 'ACZ', null, null, null, null, '\d{4}'],
        'ZM' => ['%N%n%O%n%A%n%Z %C', null, null, null, null, null, '\d{5}'],
    ];

    /**
     * @var string[]
     */
    private static $defaultFormat = ['%N%n%O%n%A%n%C', 'AC', 'C', null, null, null, null];

    /**
     * @var string[]
     */
    private $tokens = [
        '%S' => '', //admin area / state
        '%C' => '', //locality / city
        '%O' => '', //organization
        '%D' => '', //sublocality
        '%Z' => '', //postal code
        '%X' => '', //sorting code
        '%A' => '', //street address
        '%R' => '', //country
        '%N' => '', //person
    ];

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?Locale $locale = null)
    {
        $this->locale = $locale ?? DefaultLocale::fromString('de-DE');
    }

    public function format(Address $address): string
    {
        $addressFormat = self::$formats[strtoupper(trim((string) $address->getCountryCode()))] ?? self::$defaultFormat;

        $format = $addressFormat[0] ?? self::$defaultFormat[0];

        if (! strpos($format, '%R')) {
            $format .= '%n%R';
        }

        $tokens = $this->tokens;

        $tokens['%O'] = $address->getOrganization();
        $tokens['%A'] = implode("\n", [(string) $address->getAddressLine1(), (string) $address->getAddressLine2(), (string) $address->getAddressLine3()]);
        $tokens['%N'] = implode(' ', [(string) $address->getNamePrefix(), (string) $address->getFirstName(), (string) $address->getLastName()]);
        $tokens['%C'] = $address->getLocality();
        $tokens['%S'] = $address->getState();
        $tokens['%Z'] = $address->getPostalCode();
        $tokens['%R'] = $this->isoCodeToName(strtoupper((string) $address->getCountryCode()));
        $tokens['%X'] = $address->getSortingCode();
        $tokens['%D'] = $address->getSubLocality();

        foreach ($tokens as $key => $value) {
            $tokens[$key] = trim((string) $value);
        }

        $tokens['%n'] = "\n";

        $upperCase = (string) $addressFormat[2];

        for ($i = 0, $iMax = strlen($upperCase); $i < $iMax; $i++) {
            $char = $upperCase[$i];
            $tokens['%' . $char] = mb_strtoupper($tokens['%' . $char] ?? '');
        }

        $result = str_replace(array_keys($tokens), array_values($tokens), $format);
        $result = preg_replace('/\n+/', "\n", $result) ?? $result;
        $result = preg_replace('/ +/', ' ', $result) ?? $result;
        $result = preg_replace('/ \n/', '', $result) ?? $result;
        $result = trim($result);

        return $result;
    }

    public function generateUsageTemplate(string $countryCode): Address
    {
        $addressFormat = self::$formats[strtoupper(trim($countryCode))] ?? self::$defaultFormat;
        $format = $addressFormat[0] ?? self::$defaultFormat[0];

        if (! strpos($format, '%R')) {
            $format .= '%n%R';
        }

        $mapping = [
            'organization' => '%O',
            'namePrefix' => '%N',
            'firstName' => '%N',
            'lastName' => '%N',
            'addressLine1' => '%A',
            'addressLine2' => '%A',
            'addressLine3' => '%A',
            'sortingCode' => '%X',
            'postalCode' => '%Z',
            'locality' => '%C',
            'subLocality' => '%D',
            'state' => '%S',
            'countryCode' => '%R',
        ];

        $data = $mapping;

        foreach (array_keys($this->tokens) as $token) {
            if (strpos($format, $token) !== false) {
                foreach ($mapping as $argument => $mappedData) {
                    if ($mappedData === $token) {
                        $data[$argument] = 'optional';
                    }
                }
            }
        }

        $required = $addressFormat[1] ?? self::$defaultFormat[1];
        $requiredTokens = str_split($required);

        if (! in_array('R', $requiredTokens, true)) {
            $requiredTokens[] = 'R';
        }

        if (strpos($format, '%Z') !== false) {
            $requiredTokens[] = 'Z';
        }

        foreach ($requiredTokens as $token) {
            foreach ($mapping as $argument => $mappedData) {
                if ($mappedData === '%' . $token && $argument !== 'addressLine2' && $argument !== 'addressLine3') {
                    $data[$argument] = 'required';
                }
            }
        }

        foreach ($data as $argument => $mappedData) {
            if ($mappedData !== 'optional' && $mappedData !== 'required') {
                $data[$argument] = null;
            }
        }

        $result = new DefaultAddress(...array_values($data));
        $result->setCountryCode(strtoupper(trim($countryCode)));

        return $result;
    }

    public function generateLabelTemplate(string $countryCode): Address
    {
        $addressFormat = self::$formats[strtoupper(trim($countryCode))] ?? self::$defaultFormat;

        $data = [
            'organization' => null,
            'namePrefix' => null,
            'firstName' => null,
            'lastName' => null,
            'addressLine1' => null,
            'addressLine2' => null,
            'addressLine3' => null,
            'sortingCode' => null,
            'postalCode' => $addressFormat[5],
            'locality' => $addressFormat[3],
            'subLocality' => $addressFormat[4],
            'state' => StateData::type(strtoupper(trim($countryCode))),
            'countryCode' => null,
        ];

        return new DefaultAddress(...array_values($data));
    }

    public function generateRegexTemplate(string $countryCode): Address
    {
        $addressFormat = self::$formats[strtoupper(trim($countryCode))] ?? self::$defaultFormat;

        $data = [
            'organization' => null,
            'namePrefix' => null,
            'firstName' => null,
            'lastName' => null,
            'addressLine1' => null,
            'addressLine2' => null,
            'addressLine3' => null,
            'sortingCode' => null,
            'postalCode' => $addressFormat[6],
            'locality' => null,
            'subLocality' => null,
            'state' => null,
            'countryCode' => null,
        ];

        return new DefaultAddress(...array_values($data));
    }

    public function generateLayoutTemplate(string $countryCode): Address
    {
        $mapping = [
            'organization' => '%O',
            'namePrefix' => '%N',
            'firstName' => '%N',
            'lastName' => '%N',
            'addressLine1' => '%A',
            'addressLine2' => '%A',
            'addressLine3' => '%A',
            'sortingCode' => '%X',
            'postalCode' => '%Z',
            'locality' => '%C',
            'subLocality' => '%D',
            'state' => '%S',
            'countryCode' => '%R',
        ];

        $data = array_fill_keys(array_keys($mapping), null);

        $addressFormat = self::$formats[strtoupper(trim($countryCode))] ?? self::$defaultFormat;
        $format = $addressFormat[0] ?? self::$defaultFormat[0];

        if (! strpos($format, '%R')) {
            $format .= '%n%R';
        }

        $lines = explode('%n', $format);
        $row = 1;

        foreach ($lines as $line) {
            $column = 1;
            $fields = $line;

            while ($fields !== '') {
                while ($fields !== '' && $fields[0] !== '%') {
                    $fields = substr($fields, 1);
                }

                foreach (array_keys($this->tokens) as $token) {
                    if (strpos($fields, $token) !== 0) {
                        continue;
                    }

                    foreach ($mapping as $argument => $mappedData) {
                        if ($mappedData === $token) {
                            $data[$argument] = $row . ',' . $column;

                            if ($token === '%A') {
                                $row++;
                            } elseif ($token === '%N') {
                                $column++;
                            }
                        }
                    }

                    if ($token === '%A') {
                        $row--;
                    } elseif ($token === '%N') {
                        $column--;
                    }

                    $column++;
                    $fields = substr($fields, strlen($token));

                    break;
                }
            }

            $row++;
        }

        return new DefaultAddress(...array_values($data));
    }

    public function withLocale(Locale $locale): AddressFormatter
    {
        if ($locale->getCode() === $this->locale->getCode()) {
            return $this;
        }

        return new self($locale);
    }

    /**
     * Returns the localized name for the given country code.
     */
    protected function isoCodeToName(string $isoCode): string
    {
        return $isoCode;
    }
}
