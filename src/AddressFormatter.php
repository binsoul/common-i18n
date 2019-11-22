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
     *
     * @param Address $address
     *
     * @return string
     */
    public function format(Address $address): string;

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return AddressFormatter
     */
    public function withLocale(Locale $locale): AddressFormatter;
}
