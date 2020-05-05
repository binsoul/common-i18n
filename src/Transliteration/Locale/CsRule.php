<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Czech language.
 */
class CsRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'Č' => 'C',
        'č' => 'c',
        'Ď' => 'D',
        'ď' => 'd',
        'Ě' => 'E',
        'ě' => 'e',
        'Ň' => 'N',
        'ň' => 'n',
        'Ř' => 'R',
        'ř' => 'r',
        'Š' => 'S',
        'š' => 's',
        'Ť' => 'T',
        'ť' => 't',
        'Ů' => 'U',
        'ů' => 'u',
        'Ž' => 'Z',
        'ž' => 'z',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
