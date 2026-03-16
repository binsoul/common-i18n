<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see MutableAddress} interface.
 */
class DefaultAddress implements MutableAddress
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        private ?string $organization = null,
        private ?string $namePrefix = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?string $addressLine1 = null,
        private ?string $addressLine2 = null,
        private ?string $addressLine3 = null,
        private ?string $sortingCode = null,
        private ?string $postalCode = null,
        private ?string $locality = null,
        private ?string $subLocality = null,
        private ?string $state = null,
        private ?string $countryCode = null
    ) {
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $value): void
    {
        $this->organization = $value;
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(?string $value): void
    {
        $this->namePrefix = $value;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $value): void
    {
        $this->firstName = $value;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $value): void
    {
        $this->lastName = $value;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine1(?string $value): void
    {
        $this->addressLine1 = $value;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $value): void
    {
        $this->addressLine2 = $value;
    }

    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    public function setAddressLine3(?string $value): void
    {
        $this->addressLine3 = $value;
    }

    public function getSortingCode(): ?string
    {
        return $this->sortingCode;
    }

    public function setSortingCode(?string $value): void
    {
        $this->sortingCode = $value;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $value): void
    {
        $this->postalCode = $value;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $value): void
    {
        $this->locality = $value;
    }

    public function getSubLocality(): ?string
    {
        return $this->subLocality;
    }

    public function setSubLocality(?string $value): void
    {
        $this->subLocality = $value;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $value): void
    {
        $this->state = $value;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $value): void
    {
        $this->countryCode = $value;
    }
}
