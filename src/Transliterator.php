<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides transliteration of strings.
 */
interface Transliterator
{
    /**
     * Transliterates the given text.
     *
     * @param TransliterationRule[] $rules
     */
    public function transliterate(string $text, array $rules = []): string;
}
