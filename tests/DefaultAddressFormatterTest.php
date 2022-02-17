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

    public function test_generates_templates(): void
    {
        $addressFormatter = new DefaultAddressFormatter(DefaultLocale::fromString('de-DE'));

        $address = $addressFormatter->generateTemplate('de');
        self::assertEquals("optional\noptional optional optional\nrequired\noptional\noptional\nrequired required\nDE", $addressFormatter->format($address));

        $address = $addressFormatter->generateTemplate('ae');
        self::assertEquals("optional\noptional optional optional\nrequired\noptional\noptional\nrequired\nAE", $addressFormatter->format($address));
    }
}
