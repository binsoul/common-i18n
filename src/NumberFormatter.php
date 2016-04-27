<?php

declare (strict_types = 1);

namespace BinSoul\Common\I18n;

/**
 * Formats decimal numbers.
 */
interface NumberFormatter
{
    /**
     * Formats a decimal number.
     *
     * @param float $value
     * @param int   $decimals maximum number of fractional digits
     *
     * @return string
     */
    public function formatDecimal(float $value, int $decimals = null): string;

    /**
     * Formats a decimal number as a percent value.
     *
     * @param float $value
     * @param int   $decimals maximum number of fractional digits
     *
     * @return string
     */
    public function formatPercent(float $value, int $decimals = null): string;

    /**
     * Formats a decimal number as a currency value.
     *
     * @param float  $value
     * @param string $currencyCode ISO3 code of the currency
     *
     * @return string
     */
    public function formatCurrency(float $value, string $currencyCode = ''): string;

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return Locale
     */
    public function withLocale(Locale $locale): Locale;
}
