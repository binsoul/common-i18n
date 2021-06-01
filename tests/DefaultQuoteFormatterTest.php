<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultQuoteFormatter;
use PHPUnit\Framework\TestCase;

class DefaultQuoteFormatterTest extends TestCase
{
    public function provideDefaultQuotes()
    {
        return [
            ['en', '“a”', '‘b’'],
            ['en-GB', '‘a’', '“b”'],
            ['de', '„a“', '‚b‘'],
            ['de-CH', '«a»', '‹b›'],
        ];
    }

    /**
     * @dataProvider provideDefaultQuotes
     */
    public function test_formats_defaults(string $localeCode, string $primary, string $secondary): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultQuoteFormatter($locale);
        self::assertEquals($primary, $formatter->primary('a'));
        self::assertEquals($secondary, $formatter->secondary('b'));
    }

    public function provideDefaultArrays()
    {
        return [
            ['en', ['“a”', '“b”']],
            ['en-GB', ['‘a’', '‘b’']],
            ['de', ['„a“', '„b“']],
            ['de-CH', ['«a»', '«b»']],
        ];
    }

    /**
     * @dataProvider provideDefaultArrays
     */
    public function test_formats_arrays(string $localeCode, array $array): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultQuoteFormatter($locale);
        self::assertEquals($array, $formatter->primary(['a', 'b']));
    }
}
