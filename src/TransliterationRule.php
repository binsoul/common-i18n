<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Transforms text.
 */
interface TransliterationRule
{
    public function apply(string $text): string;
}
