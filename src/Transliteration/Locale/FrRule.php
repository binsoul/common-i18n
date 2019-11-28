<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the French language.
 */
class FrRule extends DefaultRule
{
    private static $map = [
        'À' => 'A',
        'à' => 'a',
        'Â' => 'A',
        'â' => 'a',
        'Æ' => 'AE',
        'æ' => 'ae',
        'Ç' => 'C',
        'ç' => 'c',
        'É' => 'E',
        'é' => 'e',
        'È' => 'E',
        'è' => 'e',
        'Ê' => 'E',
        'ê' => 'e',
        'Ë' => 'E',
        'ë' => 'e',
        'Ï' => 'I',
        'ï' => 'i',
        'Î' => 'I',
        'î' => 'i',
        'Ô' => 'O',
        'ô' => 'o',
        'Œ' => 'OE',
        'œ' => 'oe',
        'Ù' => 'U',
        'ù' => 'u',
        'Û' => 'U',
        'û' => 'u',
        'Ü' => 'U',
        'ü' => 'u',
        'Ÿ' => 'Y',
        'ÿ' => 'y',
        'd\'' => '',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
