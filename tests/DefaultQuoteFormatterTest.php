<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultMessage;
use BinSoul\Common\I18n\DefaultQuoteFormatter;
use BinSoul\Common\I18n\Locale;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DefaultQuoteFormatterTest extends TestCase
{
    /**
     * @return array<array{string, string, string}>
     */
    public static function provideDefaultQuotes(): array
    {
        return [
            ['en', '“a”', '‘b’'],
            ['en-GB', '‘a’', '“b”'],
            ['de', '„a“', '‚b‘'],
            ['de-CH', '«a»', '‹b›'],
        ];
    }

    #[DataProvider('provideDefaultQuotes')]
    public function test_formats_defaults(string $localeCode, string $primary, string $secondary): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultQuoteFormatter($locale);
        self::assertEquals($primary, $formatter->primary('a'));
        self::assertEquals($secondary, $formatter->secondary('b'));
    }

    /**
     * @return array<array{string, array{string, string}}>
     */
    public static function provideDefaultArrays(): array
    {
        return [
            ['en', ['“a”', '“b”']],
            ['en-GB', ['‘a’', '‘b’']],
            ['de', ['„a“', '„b“']],
            ['de-CH', ['«a»', '«b»']],
        ];
    }

    /**
     * @param array<string> $array
     */
    #[DataProvider('provideDefaultArrays')]
    public function test_formats_arrays(string $localeCode, array $array): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultQuoteFormatter($locale);
        self::assertEquals($array, $formatter->primary(['a', 'b']));
        self::assertEquals($array[0], $formatter->primary('a')); // Redundant but doesn't hurt
    }

    public function test_secondary_formats_arrays(): void
    {
        $formatter = new DefaultQuoteFormatter(DefaultLocale::fromString('en'));
        self::assertEquals(['‘a’', '‘b’'], $formatter->secondary(['a', 'b']));
    }

    public function test_uses_default_locale_de_de(): void
    {
        $formatter = new DefaultQuoteFormatter();
        // de-DE should resolve to de formats
        self::assertEquals('„a“', $formatter->primary('a'));
    }

    public function test_falls_back_to_en(): void
    {
        $formatter = new DefaultQuoteFormatter(DefaultLocale::fromString('zz-YY'));
        // zz-YY is not defined, should fallback to en
        self::assertEquals('“a”', $formatter->primary('a'));
    }

    public function test_uses_parent_locale(): void
    {
        $formatter = new DefaultQuoteFormatter(DefaultLocale::fromString('de-AT'));
        // de-AT should fallback to de
        self::assertEquals('„a“', $formatter->primary('a'));
    }

    public function test_returns_instance_with_new_locale(): void
    {
        $en = DefaultLocale::fromString('en');
        $de = DefaultLocale::fromString('de');
        $formatter = new DefaultQuoteFormatter($en);
        self::assertSame($formatter, $formatter->withLocale($en));

        $newFormatter = $formatter->withLocale($de);
        self::assertNotSame($formatter, $newFormatter);
        self::assertEquals('„a“', $newFormatter->primary('a'));
    }

    public function test_handles_various_types(): void
    {
        $formatter = new DefaultQuoteFormatter(DefaultLocale::fromString('en'));
        self::assertEquals('“1”', $formatter->primary(1));
        self::assertEquals('“1.5”', $formatter->primary(1.5));
        self::assertEquals('“1”', $formatter->primary(true));
        self::assertEquals('“”', $formatter->primary(null));
        self::assertEquals('“test”', $formatter->primary(new DefaultMessage('test')));
    }

    public function test_works_with_generic_locale_interface(): void
    {
        $locale = $this->createStub(Locale::class);
        $locale->method('getCode')->willReturn('de-CH');

        $formatter = new DefaultQuoteFormatter($locale);
        self::assertEquals('«a»', $formatter->primary('a'));
    }
}
