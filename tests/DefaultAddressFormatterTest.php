<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultAddress;
use BinSoul\Common\I18n\DefaultAddressFormatter;
use BinSoul\Common\I18n\DefaultLocale;
use PHPUnit\Framework\TestCase;

class DefaultAddressFormatterTest extends TestCase
{
    public function test_formats_empty_address(): void
    {
        $address = new DefaultAddress();
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        self::assertEmpty($addressFormatter->format($address));
    }

    public function test_formats_organisation_address(): void
    {
        $address = new DefaultAddress(
            'Organisation',
            null,
            null,
            null,
            'addressLine1',
            'addressLine2',
            'addressLine3',
            null,
            '12345',
            'City',
            null,
            'State',
            'DE'
        );

        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        self::assertEquals("Organisation\naddressLine1\naddressLine2\naddressLine3\n12345 City\nDE", $addressFormatter->format($address));
    }

    public function test_formats_private_address(): void
    {
        $address = new DefaultAddress(
            null,
            'Mr.',
            'firstName',
            'lastName',
            'addressLine1',
            'addressLine2',
            'addressLine3',
            null,
            '12345',
            'City',
            null,
            'State',
            'DE'
        );

        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        self::assertEquals("Mr. firstName lastName\naddressLine1\naddressLine2\naddressLine3\n12345 City\nDE", $addressFormatter->format($address));
    }

    public function test_uppercases_parts(): void
    {
        $address = new DefaultAddress(
            'Organisation',
            null,
            null,
            null,
            'addressLine1',
            'addressLine2',
            'addressLine3',
            null,
            '12345',
            'City',
            null,
            'State',
            'FR'
        );

        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        self::assertEquals("Organisation\naddressLine1\naddressLine2\naddressLine3\n12345 CITY\nFR", $addressFormatter->format($address));
    }

    public function test_generates_usage_templates(): void
    {
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        $address = $addressFormatter->generateUsageTemplate('de');
        self::assertEquals("optional optional optional\noptional\nrequired\noptional\noptional\nrequired required\nDE", $addressFormatter->format($address));

        $address = $addressFormatter->generateUsageTemplate('ae');
        self::assertEquals("optional optional optional\noptional\nrequired\noptional\noptional\nrequired\nAE", $addressFormatter->format($address));
    }

    public function test_generates_label_templates(): void
    {
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        $address = $addressFormatter->generateLabelTemplate('de');
        self::assertEquals('state', $address->getState());

        $address = $addressFormatter->generateLabelTemplate('ae');
        self::assertEquals('emirate', $address->getState());
    }

    public function test_generates_regex_templates(): void
    {
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        $address = $addressFormatter->generateRegexTemplate('de');
        self::assertEquals('\d{5}', $address->getPostalCode());

        $address = $addressFormatter->generateRegexTemplate('ae');
        self::assertNull($address->getPostalCode());
    }

    public function test_generates_layout_templates(): void
    {
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        $address = $addressFormatter->generateLayoutTemplate('de');
        self::assertEquals('6,1', $address->getPostalCode());
        self::assertEquals('6,2', $address->getLocality());
        self::assertNull($address->getState());

        $address = $addressFormatter->generateLayoutTemplate('ae');
        self::assertNull($address->getPostalCode());
        self::assertNull($address->getLocality());
        self::assertEquals('6,1', $address->getState());

        $address = $addressFormatter->generateLayoutTemplate('ch');
        self::assertEquals('6,1', $address->getPostalCode());
        self::assertEquals('6,2', $address->getLocality());
        self::assertNull($address->getState());
    }
}
