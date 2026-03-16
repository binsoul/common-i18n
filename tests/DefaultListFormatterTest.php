<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultListFormatter;
use BinSoul\Common\I18n\DefaultLocale;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DefaultListFormatterTest extends TestCase
{
    public function test_formats_empty_lists(): void
    {
        $locale = DefaultLocale::fromString('en');
        $formatter = new DefaultListFormatter($locale);
        self::assertEquals('', $formatter->format([]));
    }

    public function test_formats_lists_with_one_item(): void
    {
        $locale = DefaultLocale::fromString('en');
        $formatter = new DefaultListFormatter($locale);
        self::assertEquals('a', $formatter->format(['a']));
    }

    /**
     * @return array<array<string>>
     */
    public static function twoLists(): array
    {
        return [
            ['en', 'a, b', 'a and b', 'a or b'],
            ['de', 'a, b', 'a und b', 'a oder b'],
        ];
    }

    #[DataProvider('twoLists')]
    public function test_formats_lists_of_two_items(string $localeCode, string $simple, string $conjunction, string $disjunction): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultListFormatter($locale);
        self::assertEquals($simple, $formatter->format(['a', 'b']));
        self::assertEquals($conjunction, $formatter->formatConjunction(['a', 'b']));
        self::assertEquals($disjunction, $formatter->formatDisjunction(['a', 'b']));
    }

    /**
     * @return array<array<string>>
     */
    public static function threeLists(): array
    {
        return [
            ['en', 'a, b, c', 'a, b, and c', 'a, b, or c'],
            ['de', 'a, b, c', 'a, b und c', 'a, b oder c'],
        ];
    }

    #[DataProvider('threeLists')]
    public function test_formats_lists_of_three_items(string $localeCode, string $simple, string $conjunction, string $disjunction): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultListFormatter($locale);
        self::assertEquals($simple, $formatter->format(['a', 'b', 'c']));
        self::assertEquals($conjunction, $formatter->formatConjunction(['a', 'b', 'c']));
        self::assertEquals($disjunction, $formatter->formatDisjunction(['a', 'b', 'c']));
    }

    /**
     * @return array<array<string>>
     */
    public static function fiveLists(): array
    {
        return [
            ['en', 'a, b, c, d, e', 'a, b, c, d, and e', 'a, b, c, d, or e'],
            ['de', 'a, b, c, d, e', 'a, b, c, d und e', 'a, b, c, d oder e'],
        ];
    }

    #[DataProvider('fiveLists')]
    public function test_formats_lists_of_five_items(string $localeCode, string $simple, string $conjunction, string $disjunction): void
    {
        $locale = DefaultLocale::fromString($localeCode);
        $formatter = new DefaultListFormatter($locale);
        self::assertEquals($simple, $formatter->format(['a', 'b', 'c', 'd', 'e']));
        self::assertEquals($conjunction, $formatter->formatConjunction(['a', 'b', 'c', 'd', 'e']));
        self::assertEquals($disjunction, $formatter->formatDisjunction(['a', 'b', 'c', 'd', 'e']));
    }
}
