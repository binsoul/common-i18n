<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration;

use BinSoul\Common\I18n\TransliterationRule;

class LowercaseRule implements TransliterationRule
{
    public function apply(string $text): string
    {
        return mb_strtolower($text);
    }
}
