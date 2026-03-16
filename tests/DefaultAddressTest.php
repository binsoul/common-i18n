<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultAddress;
use PHPUnit\Framework\TestCase;

class DefaultAddressTest extends TestCase
{
    public function test_getters_and_setters(): void
    {
        $address = new DefaultAddress(
            'Org', 'Prefix', 'First', 'Last', 'Line 1', 'Line 2', 'Line 3', 'Sorting', 'Postal', 'Locality', 'SubLocality', 'State', 'DE'
        );

        self::assertEquals('Org', $address->getOrganization());
        self::assertEquals('Prefix', $address->getNamePrefix());
        self::assertEquals('First', $address->getFirstName());
        self::assertEquals('Last', $address->getLastName());
        self::assertEquals('Line 1', $address->getAddressLine1());
        self::assertEquals('Line 2', $address->getAddressLine2());
        self::assertEquals('Line 3', $address->getAddressLine3());
        self::assertEquals('Sorting', $address->getSortingCode());
        self::assertEquals('Postal', $address->getPostalCode());
        self::assertEquals('Locality', $address->getLocality());
        self::assertEquals('SubLocality', $address->getSubLocality());
        self::assertEquals('State', $address->getState());
        self::assertEquals('DE', $address->getCountryCode());

        $address->setOrganization('NewOrg');
        self::assertEquals('NewOrg', $address->getOrganization());

        $address->setNamePrefix('NewPrefix');
        self::assertEquals('NewPrefix', $address->getNamePrefix());

        $address->setFirstName('NewFirst');
        self::assertEquals('NewFirst', $address->getFirstName());

        $address->setLastName('NewLast');
        self::assertEquals('NewLast', $address->getLastName());

        $address->setAddressLine1('NewLine1');
        self::assertEquals('NewLine1', $address->getAddressLine1());

        $address->setAddressLine2('NewLine2');
        self::assertEquals('NewLine2', $address->getAddressLine2());

        $address->setAddressLine3('NewLine3');
        self::assertEquals('NewLine3', $address->getAddressLine3());

        $address->setSortingCode('NewSorting');
        self::assertEquals('NewSorting', $address->getSortingCode());

        $address->setPostalCode('NewPostal');
        self::assertEquals('NewPostal', $address->getPostalCode());

        $address->setLocality('NewLocality');
        self::assertEquals('NewLocality', $address->getLocality());

        $address->setSubLocality('NewSubLocality');
        self::assertEquals('NewSubLocality', $address->getSubLocality());

        $address->setState('NewState');
        self::assertEquals('NewState', $address->getState());

        $address->setCountryCode('US');
        self::assertEquals('US', $address->getCountryCode());
    }
}
