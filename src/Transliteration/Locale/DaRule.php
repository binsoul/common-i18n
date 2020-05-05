<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Danish language.
 */
class DaRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'Æ' => 'Ae',
        'æ' => 'ae',
        'Ø' => 'Oe',
        'ø' => 'oe',
        'Å' => 'Aa',
        'å' => 'aa',
        'É' => 'E',
        'é' => 'e',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
