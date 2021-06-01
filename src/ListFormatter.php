<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Formats lists.
 */
interface ListFormatter
{
    /**
     * Formats a list.
     */
    public function format(array $values): string;

    /**
     * Formats a list and includes an "and".
     */
    public function formatConjunction(array $values): string;

    /**
     * Formats a list and includes an "or".
     */
    public function formatDisjunction(array $values): string;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
