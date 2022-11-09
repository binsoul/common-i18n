<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Formats addresses.
 */
interface AddressFormatter
{
    /**
     * Formats an address.
     */
    public function format(Address $address): string;

    /**
     * Returns an address where all fields contain either "required", "optional" or null if the field is not visible.
     */
    public function generateUsageTemplate(string $countryCode): Address;

    /**
     * Returns an address where all fields contain a label code.
     */
    public function generateLabelTemplate(string $countryCode): Address;

    /**
     * Returns an address where all fields contain either a regular expression or null if no special format is required.
     */
    public function generateRegexTemplate(string $countryCode): Address;

    /**
     * Returns an address where all fields contain a row and a column value or null if the field is not visible.
     */
    public function generateLayoutTemplate(string $countryCode): Address;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
