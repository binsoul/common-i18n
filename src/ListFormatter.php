<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Formats lists.
 */
interface ListFormatter
{
    /**
     * Formats a list.
     *
     * @param array<string|int|float|bool|null|Stringable> $values
     */
    public function format(array $values): string;

    /**
     * Formats a list and includes an "and".
     *
     * @param array<string|int|float|bool|null|Stringable> $values
     */
    public function formatConjunction(array $values): string;

    /**
     * Formats a list and includes an "or".
     *
     * @param array<string|int|float|bool|null|Stringable> $values
     */
    public function formatDisjunction(array $values): string;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
