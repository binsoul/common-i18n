<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Finnish language.
 */
class FiRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'Ä' => 'A',
        'ä' => 'a',
        'Ö' => 'O',
        'ö' => 'o',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
