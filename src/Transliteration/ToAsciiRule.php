<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n\Transliteration;

use BinSoul\Common\I18n\TransliterationRule;
use Throwable;

class ToAsciiRule implements TransliterationRule
{
    public function apply(string $text): string
    {
        $result = $text;
        $wasConverted = false;

        if (function_exists('transliterator_transliterate')) {
            try {
                $converted = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $result);

                if ($converted !== false) {
                    $result = $converted;
                    $wasConverted = true;
                }
            } catch (Throwable $e) {
                // ignore
            }
        }

        if (! $wasConverted && function_exists('iconv')) {
            $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $result);

            if ($converted !== false) {
                $result = $converted;
            }
        }

        return $result;
    }
}
