<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the German language.
 */
class DeRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'Ä' => 'Ae',
        'ä' => 'ae',
        'Ü' => 'Ue',
        'ü' => 'ue',
        'Ö' => 'Oe',
        'ö' => 'oe',
        'ẞ' => 'SS',
        'ß' => 'ss',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
