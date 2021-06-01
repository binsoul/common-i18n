<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Formats quotes.
 */
interface QuoteFormatter
{
    /**
     * Surrounds the value with primary quotes.
     */
    public function primary($value);

    /**
     * Surrounds the value with secondary quotes.
     */
    public function secondary($value);

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
