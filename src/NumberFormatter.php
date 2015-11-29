<?php

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
    public function formatDecimal($value, $decimals = null);

    /**
     * Formats a decimal number as a percent value.
     *
     * @param float $value
     * @param int   $decimals maximum number of fractional digits
     *
     * @return string
     */
    public function formatPercent($value, $decimals = null);

    /**
     * Formats a decimal number as a currency value.
     *
     * @param float  $value
     * @param string $currencyCode ISO3 code of the currency
     *
     * @return string
     */
    public function formatCurrency($value, $currencyCode);

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return self
     */
    public function withLocale(Locale $locale);
}
