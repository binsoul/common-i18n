<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents an address which is mutable.
 */
interface MutableAddress extends Address
{
    /**
     * Sets the organization.
     */
    public function setOrganization(?string $value): void;

    /**
     * Sets the name prefix / salutation.
     */
    public function setNamePrefix(?string $value): void;

    /**
     * Sets the first name.
     */
    public function setFirstName(?string $value): void;

    /**
     * Sets the last name.
     */
    public function setLastName(?string $value): void;

    /**
     * Sets the address line 1.
     */
    public function setAddressLine1(?string $value): void;

    /**
     * Sets the address line 2.
     */
    public function setAddressLine2(?string $value): void;

    /**
     * Sets the address line 3.
     */
    public function setAddressLine3(?string $value): void;

    /**
     * Sets the sorting code.
     */
    public function setSortingCode(?string $value): void;

    /**
     * Sets the postal code.
     */
    public function setPostalCode(?string $value): void;

    /**
     * Sets the locality / city.
     */
    public function setLocality(?string $value): void;

    /**
     * Sets the sub locality.
     */
    public function setSubLocality(?string $value): void;

    /**
     * Sets the state.
     */
    public function setState(?string $value): void;

    /**
     * Sets the iso2 code of the country.
     */
    public function setCountryCode(?string $value): void;
}
