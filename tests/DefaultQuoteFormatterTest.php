<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultQuoteFormatter;
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
    }
}
