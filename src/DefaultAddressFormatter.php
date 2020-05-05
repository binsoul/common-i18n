<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

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
        //address_format, address_required, address_upcase
        'DZ' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'AS' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'AD' => ['%O%n%P %F %L%n%A%n%Z %S', 'AS', 'S'],
        'AG' => [null, 'A', ''],
        'AR' => ['%O%n%P %F %L%n%A%n%Z %C%n%S', null, 'ACZ'],
        'AM' => ['%O%n%P %F %L%n%A%n%Z%n%C%n%S', null, ''],
        'AU' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'CS'],
        'AT' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'AZ' => ['%O%n%P %F %L%n%A%nAZ %Z %C', null, ''],
        'BS' => ['%O%n%P %F %L%n%A%n%C, %S', null, ''],
        'BH' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'BD' => ['%O%n%P %F %L%n%A%n%C - %Z', null, ''],
        'BY' => ['%S%n%Z %C %X%n%A%n%O%n%P %F %L', null, ''],
        'BE' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'BJ' => [null, null, 'AC'],
        'BM' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'BO' => [null, null, 'AC'],
        'BA' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'BR' => ['%O%n%P %F %L%n%A%n%C-%S%n%Z', 'ASCZ', 'CS'],
        'IO' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'BN' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'BG' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'BF' => ['%O%n%P %F %L%n%A%n%C %X', null, ''],
        'KH' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'CA' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOSZ'],
        'CV' => ['%O%n%P %F %L%n%A%n%Z %C%n%S', null, ''],
        'KY' => ['%O%n%P %F %L%n%A%n%S', 'AS', ''],
        'CL' => ['%O%n%P %F %L%n%A%n%Z %C%n%S', null, ''],
        'CN' => ['%Z%n%S%C%D%n%A%n%O%n%P %F %L', 'ACSZ', 'S'],
        'CX' => ['%O%n%P %F %L%n%A%n%C %S %Z', null, 'CS'],
        'CC' => ['%O%n%P %F %L%n%A%n%C %S %Z', null, 'CS'],
        'CO' => ['%O%n%P %F %L%n%A%n%C, %S', null, ''],
        'KM' => [null, null, 'AC'],
        'CK' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'CR' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'CI' => ['%O%n%P %F %L%n%X %A %C %X', null, ''],
        'HR' => ['%O%n%P %F %L%n%A%nHR-%Z %C', null, ''],
        'CY' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'CZ' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'DK' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'DO' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'EC' => ['%O%n%P %F %L%n%A%n%Z%n%C', null, 'CZ'],
        'EG' => ['%O%n%P %F %L%n%A%n%C%n%S%n%Z', null, ''],
        'SV' => ['%O%n%P %F %L%n%A%n%C%n%S', 'ACS', 'CS'],
        'EE' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'ET' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'FK' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'FO' => ['%O%n%P %F %L%n%A%nFO%Z %C', null, ''],
        'FI' => ['%O%n%P %F %L%n%A%nFI-%Z %C', 'ACZ', ''],
        'FR' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'CXL'],
        'GF' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'PF' => ['%O%n%P %F %L%n%A%n%Z %C %S', 'ACSZ', 'CS'],
        'GE' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'DE' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'GI' => ['%O%n%P %F %L%n%A', 'A', ''],
        'GR' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'GL' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'GP' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'GU' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'GT' => ['%O%n%P %F %L%n%A%n%Z- %C', null, ''],
        'GN' => ['%O%n%P %F %L%n%Z %A %C', null, ''],
        'GW' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'HT' => ['%O%n%P %F %L%n%A%nHT%Z %C %X', null, ''],
        'HM' => ['%O%n%P %F %L%n%A%n%C %S %Z', null, 'CS'],
        'HN' => ['%O%n%P %F %L%n%A%n%C, %S%n%Z', 'ACS', ''],
        'HK' => ['%S%n%A%n%O%n%P %F %L', 'AS', 'S'],
        'HU' => ['%O%n%P %F %L%n%C%n%A%n%Z', null, 'ACPFLO'],
        'IS' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'IN' => ['%O%n%P %F %L%n%A%n%C %Z%n%S', 'ACSZ', ''],
        'ID' => ['%O%n%P %F %L%n%A%n%C %Z%n%S', null, ''],
        'IQ' => ['%O%n%P %F %L%n%A%n%C, %S%n%Z', 'ACS', 'CS'],
        'IE' => ['%O%n%P %F %L%n%A%n%C%n%S', null, ''],
        'IL' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'IT' => ['%O%n%P %F %L%n%A%n%Z %C %S', 'ACSZ', 'CS'],
        'JM' => ['%O%n%P %F %L%n%A%n%C%n%S %X', 'ACS', ''],
        'JP' => ['〒%Z%n%S%C%n%A%n%O%n%P %F %L', 'ACSZ', 'S'],
        'JO' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'KZ' => ['%Z%n%S%n%C%n%A%n%O%n%P %F %L', null, ''],
        'KE' => ['%O%n%P %F %L%n%A%n%C%n%Z', null, ''],
        'KI' => ['%O%n%P %F %L%n%A%n%S%n%C', null, 'ACPFLOS'],
        'KR' => ['%S %C%D%n%A%n%O%n%P %F %L%nSEOUL', 'ACSZ', 'Z'],
        'KW' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'KG' => ['%Z %C %X%n%A%n%O%n%P %F %L', null, ''],
        'LA' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'LV' => ['%O%n%P %F %L%n%A%n%C, LV-%Z', null, ''],
        'LB' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'LS' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'LR' => ['%O%n%P %F %L%n%A%n%Z %C %X', null, ''],
        'LI' => ['%O%n%P %F %L%n%A%nFL-%Z %C', 'ACZ', ''],
        'LT' => ['%O%n%P %F %L%n%A%nLT-%Z %C', null, ''],
        'LU' => ['%O%n%P %F %L%n%A%nL-%Z %C', 'ACZ', ''],
        'MO' => ['%A%n%O%n%P %F %L', 'A', ''],
        'MK' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'MG' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'MW' => ['%O%n%P %F %L%n%A%n%C %X', null, ''],
        'MY' => ['%O%n%P %F %L%n%A%n%Z %C, %S', 'ACZ', 'CS'],
        'MV' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'MT' => ['%O%n%P %F %L%n%A%n%C %Z', null, 'CZ'],
        'MH' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'MQ' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'MR' => [null, null, 'AC'],
        'MU' => ['%O%n%P %F %L%n%A%n%Z%n%C', null, 'CZ'],
        'YT' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'MX' => ['%O%n%P %F %L%n%A%n%Z %C, %S', 'ACZ', 'CSZ'],
        'FM' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'MD' => ['%O%n%P %F %L%n%A%nMD-%Z %C', null, ''],
        'MC' => ['%O%n%P %F %L%n%A%nMC-%Z %C %X', null, ''],
        'MN' => ['%O%n%P %F %L%n%A%n%S %C-%X%n%Z', null, ''],
        'MA' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'MZ' => ['%O%n%P %F %L%n%A%n%C', null, ''],
        'NR' => ['%O%n%P %F %L%n%A%n%S', 'AS', ''],
        'NP' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'NL' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'NC' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'NZ' => ['%O%n%P %F %L%n%A%n%C %Z', 'ACZ', ''],
        'NI' => ['%O%n%P %F %L%n%A%n%Z%n%C, %S', null, 'CS'],
        'NE' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'NG' => ['%O%n%P %F %L%n%A%n%C %Z%n%S', null, 'CS'],
        'NF' => ['%O%n%P %F %L%n%A%n%C %S %Z', null, 'CS'],
        'MP' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'NO' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'OM' => ['%O%n%P %F %L%n%A%n%Z%n%C', null, ''],
        'PK' => ['%O%n%P %F %L%n%A%n%C-%Z', null, ''],
        'PW' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'PA' => ['%O%n%P %F %L%n%A%n%C%n%S', null, 'CS'],
        'PG' => ['%O%n%P %F %L%n%A%n%C %Z %S', 'ACS', ''],
        'PY' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'PH' => ['%O%n%P %F %L%n%A%n%Z %C%n%S', null, ''],
        'PN' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'PL' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'PT' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'PR' => ['%O%n%P %F %L%n%A%n%C PR %Z', 'ACZ', 'ACPFLO'],
        'QA' => [null, null, 'AC'],
        'RE' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'RO' => ['%O%n%P %F %L%n%A%n%Z %C', null, 'AC'],
        'RU' => ['%Z %C  %n%A%n%O%n%P %F %L', 'ACZ', 'AC'],
        'RW' => [null, null, 'AC'],
        'KN' => ['%O%n%P %F %L%n%A%n%C, %S', 'ACS', ''],
        'SM' => ['%O%n%P %F %L%n%A%n%Z %C', 'AZ', ''],
        'ST' => ['%O%n%P %F %L%n%A%n%C %X', null, ''],
        'SA' => ['%O%n%P %F %L%n%A%n%C %Z', null, ''],
        'SN' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'SC' => ['%O%n%P %F %L%n%A%n%C%n%S', null, 'S'],
        'SG' => ['%O%n%P %F %L%n%A%nSINGAPORE %Z', 'AZ', ''],
        'SK' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'SI' => ['%O%n%P %F %L%n%A%nSI- %Z %C', null, ''],
        'SO' => ['%O%n%P %F %L%n%A%n%C, %S %Z', 'ACS', 'ACS'],
        'ZA' => ['%O%n%P %F %L%n%A%n%C%n%Z', 'ACZ', ''],
        'GS' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'ES' => ['%O%n%P %F %L%n%A%n%Z %C %S', 'ACSZ', 'CS'],
        'LK' => ['%O%n%P %F %L%n%A%n%C%n%Z', null, ''],
        'SH' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'PM' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'SR' => ['%O%n%P %F %L%n%A%n%C %X%n%S', null, 'AS'],
        'SJ' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'SZ' => ['%O%n%P %F %L%n%A%n%C%n%Z', null, 'ACZ'],
        'SE' => ['%O%n%P %F %L%n%A%nSE-%Z %C', 'ACZ', ''],
        'CH' => ['%O%n%P %F %L%n%A%nCH-%Z %C', 'ACZ', ''],
        'TW' => ['%Z%n%S%C%n%A%n%O%n%P %F %L', 'ACSZ', ''],
        'TJ' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'TH' => ['%O%n%P %F %L%n%A%n%C%n%S %Z', null, 'S'],
        'TN' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'TR' => ['%O%n%P %F %L%n%A%n%Z %C', 'ACZ', ''],
        'TM' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'TC' => ['%O%n%P %F %L%n%A%n%X%n%C%n%Z', 'ACZ', 'CZ'],
        'TV' => ['%O%n%P %F %L%n%A%n%X%n%C%n%S', null, 'ACS'],
        'UA' => ['%Z %C%n%A%n%O%n%P %F %L', null, ''],
        'AE' => ['%O%n%P %F %L%n%A%n%S', 'AS', ''],
        'GB' => ['%O%n%P %F %L%n%A%n%C%n%S%n%Z', 'ACZ', 'CZ'],
        'US' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'CS'],
        'UM' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACS', 'ACPFLOS'],
        'UY' => ['%O%n%P %F %L%n%A%n%Z %C %S', null, 'CS'],
        'UZ' => ['%O%n%P %F %L%n%A%n%Z %C%n%S', null, 'CS'],
        'VA' => ['%O%n%P %F %L%n%A%n%Z %C', null, ''],
        'VE' => ['%O%n%P %F %L%n%A%n%C %Z, %S', 'ACS', 'CS'],
        'VN' => ['%O%n%P %F %L%n%A%n%C%n%S', 'AC', ''],
        'VG' => [null, 'A', ''],
        'VI' => ['%O%n%P %F %L%n%A%n%C %S %Z', 'ACSZ', 'ACPFLOS'],
        'WF' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'YE' => [null, 'AC', ''],
        'CD' => ['%O%n%P %F %L%n%A%n%C %X', null, ''],
        'ZM' => ['%O%n%P %F %L%n%A%n%Z %C', 'AC', ''],
        'MF' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
        'BL' => ['%O%n%P %F %L%n%A%n%Z %C %X', 'ACZ', 'ACXL'],
    ];

    /**
     * @var string[]
     */
    private static $defaultFormat = ['%N%n%O%n%A%n%C', 'AC', 'C'];

    /**
     * @var string[]
     */
    private $tokens = [
        '%S' => '', //admin area / state
        '%C' => '', //locality / city
        '%O' => '', //organization
        '%D' => '', //dependent locality
        '%Z' => '', //postal code
        '%X' => '', //sorting code
        '%A' => '', //street address
        '%R' => '', //country
        '%P' => '', //name prefix
        '%F' => '', //first name
        '%L' => '', //last name
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
        $addressFormat = self::$formats[strtoupper((string) $address->getCountryCode())] ?? self::$defaultFormat;

        $format = $addressFormat[0] ?? self::$defaultFormat[0];

        if (! strpos($format, '%R')) {
            $format .= '%n%R';
        }

        $tokens = $this->tokens;

        $tokens['%O'] = $address->getOrganization();
        $tokens['%A'] = implode("\n", [(string) $address->getAddressLine1(), (string) $address->getAddressLine2(), (string) $address->getAddressLine3()]);
        $tokens['%P'] = $address->getNamePrefix();
        $tokens['%F'] = $address->getFirstName();
        $tokens['%L'] = $address->getLastName();
        $tokens['%N'] = implode(' ', [(string) $address->getNamePrefix(), (string) $address->getFirstName(), (string) $address->getLastName()]);
        $tokens['%C'] = $address->getLocality();
        $tokens['%S'] = $address->getAdminArea();
        $tokens['%Z'] = $address->getPostalCode();
        $tokens['%R'] = $this->isoCodeToName(strtoupper((string) $address->getCountryCode()));
        $tokens['%X'] = $address->getSortingCode();
        $tokens['%D'] = $address->getDependentLocality();
        $tokens['%n'] = "\n";

        foreach ($tokens as $key => $value) {
            $tokens[$key] = (string) $value;
        }

        $upperCase = $addressFormat[2] ?? self::$defaultFormat[2];

        for ($i = 0, $iMax = \strlen($upperCase); $i < $iMax; $i++) {
            $char = $upperCase[$i];
            $tokens['%' . $char] = mb_strtoupper($tokens['%' . $char] ?? '');
        }

        $result = str_replace(array_keys($tokens), array_values($tokens), $format);
        $result = preg_replace('/\n+/', "\n", $result) ?? $result;
        $result = preg_replace('/ +/', ' ', $result) ?? $result;
        $result = trim($result);

        return $result;
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
