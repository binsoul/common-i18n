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
     *
     * @return string|null
     */
    public function getOrganization(): ?string;

    /**
     * Returns the name prefix / salutation.
     *
     * @return string|null
     */
    public function getNamePrefix(): ?string;

    /**
     * Returns the first name.
     *
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * Returns the last name.
     *
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * Returns the address line 1.
     *
     * @return string|null
     */
    public function getAddressLine1(): ?string;

    /**
     * Returns the address line 2.
     *
     * @return string|null
     */
    public function getAddressLine2(): ?string;

    /**
     * Returns the address line 3.
     *
     * @return string|null
     */
    public function getAddressLine3(): ?string;

    /**
     * Returns the sorting code.
     *
     * @return string|null
     */
    public function getSortingCode(): ?string;

    /**
     * Returns the postal code.
     *
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * Returns the locality / city.
     *
     * @return string|null
     */
    public function getLocality(): ?string;

    /**
     * Returns the dependent locality.
     *
     * @return string|null
     */
    public function getDependentLocality(): ?string;

    /**
     * Returns the admin area / state.
     *
     * @return string|null
     */
    public function getAdminArea(): ?string;

    /**
     * Returns the iso2 code of the country.
     *
     * @return string|null
     */
    public function getCountryCode(): ?string;
}
