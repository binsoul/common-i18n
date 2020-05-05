<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration\Locale;

/**
 * Provides transliteration for the Russian language.
 */
class RuRule extends DefaultRule
{
    /**
     * @var string[]
     */
    private static $map = [
        'Ъ' => '',
        'ъ' => '',
        'Ь' => '',
        'ь' => '',
        'А' => 'A',
        'а' => 'a',
        'Б' => 'B',
        'б' => 'b',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Д' => 'D',
        'д' => 'd',
        'Е' => 'E',
        'е' => 'e',
        'Ё' => 'E',
        'ё' => 'e',
        'Э' => 'E',
        'э' => 'e',
        'Ф' => 'F',
        'ф' => 'f',
        'Г' => 'G',
        'г' => 'g',
        'Х' => 'H',
        'х' => 'h',
        'И' => 'I',
        'и' => 'i',
        'Й' => 'Y',
        'й' => 'y',
        'Я' => 'Ya',
        'я' => 'ya',
        'Ю' => 'Yu',
        'ю' => 'yu',
        'К' => 'K',
        'к' => 'k',
        'Л' => 'L',
        'л' => 'l',
        'М' => 'M',
        'м' => 'm',
        'Н' => 'N',
        'н' => 'n',
        'О' => 'O',
        'о' => 'o',
        'П' => 'P',
        'п' => 'p',
        'Р' => 'R',
        'р' => 'r',
        'С' => 'S',
        'с' => 's',
        'Ш' => 'Sh',
        'ш' => 'sh',
        'Щ' => 'Shch',
        'щ' => 'shch',
        'Т' => 'T',
        'т' => 't',
        'У' => 'U',
        'у' => 'u',
        'Ы' => 'Y',
        'ы' => 'y',
        'З' => 'Z',
        'з' => 'z',
        'Ж' => 'Zh',
        'ж' => 'zh',
        'ц' => 'c',
        'ч' => 'ch',
        'в' => 'v',
    ];

    public function apply(string $text): string
    {
        $result = strtr($text, self::$map);

        return parent::apply($result);
    }
}
