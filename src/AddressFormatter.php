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
     * Returns an address where all fields contain either "required", "optional" or null if not needed.
     */
    public function generateTemplate(string $countryCode): Address;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
