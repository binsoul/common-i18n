<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Norwegian Bokmål language.
 */
class NbRule extends DefaultRule
{
    private static $map = [
        'Æ' => 'AE',
        'æ' => 'ae',
        'Ø' => 'OE',
        'ø' => 'oe',
        'Å' => 'AA',
        'å' => 'aa',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
