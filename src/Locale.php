<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a BCP 47 language tag extended with POSIX modifiers.
 */
interface Locale
{
    /**
     * Returns the complete code.
     */
    public function getCode(string $separator = '-'): string;
}
