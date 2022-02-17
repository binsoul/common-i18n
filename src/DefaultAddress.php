<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see Address} interface.
 */
class DefaultAddress implements Address
{
    /**
     * @var string|null
     */
    private $organization;

    /**
     * @var string|null
     */
    private $namePrefix;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $addressLine1;

    /**
     * @var string|null
     */
    private $addressLine2;

    /**
     * @var string|null
     */
    private $addressLine3;

    /**
     * @var string|null
     */
    private $sortingCode;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $locality;

    /**
     * @var string|null
     */
    private $subLocality;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $countryCode;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        ?string $organization = null,
        ?string $namePrefix = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $addressLine1 = null,
        ?string $addressLine2 = null,
        ?string $addressLine3 = null,
        ?string $sortingCode = null,
        ?string $postalCode = null,
        ?string $locality = null,
        ?string $subLocality = null,
        ?string $state = null,
        ?string $countryCode = null
    ) {
        $this->organization = $organization;
        $this->namePrefix = $namePrefix;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->addressLine3 = $addressLine3;
        $this->sortingCode = $sortingCode;
        $this->postalCode = $postalCode;
        $this->locality = $locality;
        $this->subLocality = $subLocality;
        $this->state = $state;
        $this->countryCode = $countryCode;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): void
    {
        $this->organization = $organization;
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(?string $namePrefix): void
    {
        $this->namePrefix = $namePrefix;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine1(?string $addressLine1): void
    {
        $this->addressLine1 = $addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $addressLine2): void
    {
        $this->addressLine2 = $addressLine2;
    }

    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    public function setAddressLine3(?string $addressLine3): void
    {
        $this->addressLine3 = $addressLine3;
    }

    public function getSortingCode(): ?string
    {
        return $this->sortingCode;
    }

    public function setSortingCode(?string $sortingCode): void
    {
        $this->sortingCode = $sortingCode;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): void
    {
        $this->locality = $locality;
    }

    public function getSubLocality(): ?string
    {
        return $this->subLocality;
    }

    public function setSubLocality(?string $subLocality): void
    {
        $this->subLocality = $subLocality;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }
}
