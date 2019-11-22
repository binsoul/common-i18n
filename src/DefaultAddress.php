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
    private $dependentLocality;
    /**
     * @var string|null
     */
    private $adminArea;
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
        ?string $dependentLocality = null,
        ?string $adminArea = null,
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
        $this->dependentLocality = $dependentLocality;
        $this->adminArea = $adminArea;
        $this->countryCode = $countryCode;
    }

    /**
     * @return string|null
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param string|null $organization
     */
    public function setOrganization(?string $organization): void
    {
        $this->organization = $organization;
    }

    /**
     * @return string|null
     */
    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    /**
     * @param string|null $namePrefix
     */
    public function setNamePrefix(?string $namePrefix): void
    {
        $this->namePrefix = $namePrefix;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    /**
     * @param string|null $addressLine1
     */
    public function setAddressLine1(?string $addressLine1): void
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return string|null
     */
    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    /**
     * @param string|null $addressLine2
     */
    public function setAddressLine2(?string $addressLine2): void
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return string|null
     */
    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    /**
     * @param string|null $addressLine3
     */
    public function setAddressLine3(?string $addressLine3): void
    {
        $this->addressLine3 = $addressLine3;
    }

    /**
     * @return string|null
     */
    public function getSortingCode(): ?string
    {
        return $this->sortingCode;
    }

    /**
     * @param string|null $sortingCode
     */
    public function setSortingCode(?string $sortingCode): void
    {
        $this->sortingCode = $sortingCode;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getLocality(): ?string
    {
        return $this->locality;
    }

    /**
     * @param string|null $locality
     */
    public function setLocality(?string $locality): void
    {
        $this->locality = $locality;
    }

    /**
     * @return string|null
     */
    public function getDependentLocality(): ?string
    {
        return $this->dependentLocality;
    }

    /**
     * @param string|null $dependentLocality
     */
    public function setDependentLocality(?string $dependentLocality): void
    {
        $this->dependentLocality = $dependentLocality;
    }

    /**
     * @return string|null
     */
    public function getAdminArea(): ?string
    {
        return $this->adminArea;
    }

    /**
     * @param string|null $adminArea
     */
    public function setAdminArea(?string $adminArea): void
    {
        $this->adminArea = $adminArea;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     */
    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }
}
