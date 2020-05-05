<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Italian language.
 */
class ItRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'À' => 'A',
        'à' => 'a',
        'È' => 'E',
        'è' => 'e',
        'É' => 'E',
        'é' => 'e',
        'Ì' => 'I',
        'ì' => 'i',
        'Ò' => 'O',
        'ò' => 'o',
        'Ù' => 'U',
        'ù' => 'u',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
