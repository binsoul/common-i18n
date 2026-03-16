<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Formats quotes.
 */
interface QuoteFormatter
{
    /**
     * Surrounds the value with primary quotes.
     *
     * @param string|int|float|bool|null|Stringable|array<string|int|float|bool|null|Stringable> $value
     *
     * @return string|array<string>
     *
     * @phpstan-return ($value is array ? array<string> : string)
     */
    public function primary(string|int|float|bool|null|Stringable|array $value): string|array;

    /**
     * Surrounds the value with secondary quotes.
     *
     * @param string|int|float|bool|null|Stringable|array<string|int|float|bool|null|Stringable> $value
     *
     * @return string|array<string>
     *
     *  @phpstan-return ($value is array ? array<string> : string)
     */
    public function secondary(string|int|float|bool|null|Stringable|array $value): string|array;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
