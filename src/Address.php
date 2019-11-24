<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents an address.
 */
interface Address
{
    /**
     * Returns the organization.
     */
    public function getOrganization(): ?string;

    /**
     * Returns the name prefix / salutation.
     */
    public function getNamePrefix(): ?string;

    /**
     * Returns the first name.
     */
    public function getFirstName(): ?string;

    /**
     * Returns the last name.
     */
    public function getLastName(): ?string;

    /**
     * Returns the address line 1.
     */
    public function getAddressLine1(): ?string;

    /**
     * Returns the address line 2.
     */
    public function getAddressLine2(): ?string;

    /**
     * Returns the address line 3.
     */
    public function getAddressLine3(): ?string;

    /**
     * Returns the sorting code.
     */
    public function getSortingCode(): ?string;

    /**
     * Returns the postal code.
     */
    public function getPostalCode(): ?string;

    /**
     * Returns the locality / city.
     */
    public function getLocality(): ?string;

    /**
     * Returns the dependent locality.
     */
    public function getDependentLocality(): ?string;

    /**
     * Returns the admin area / state.
     */
    public function getAdminArea(): ?string;

    /**
     * Returns the iso2 code of the country.
     */
    public function getCountryCode(): ?string;
}
