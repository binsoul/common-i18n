<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Formats decimal numbers.
 */
interface NumberFormatter
{
    /**
     * Formats a decimal number.
     *
     * @param int $decimals maximum number of fractional digits
     */
    public function formatDecimal(float $value, ?int $decimals = null): string;

    /**
     * Formats a decimal number as a percent value.
     *
     * @param int $decimals maximum number of fractional digits
     */
    public function formatPercent(float $value, ?int $decimals = null): string;

    /**
     * Formats a decimal number as a currency value.
     *
     * @param string $currencyCode ISO3 code of the currency
     */
    public function formatCurrency(float $value, string $currencyCode = ''): string;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
