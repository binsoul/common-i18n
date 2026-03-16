<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DefaultLocaleTest extends TestCase
{
    /**
     * @return array<string, array<string>>
     */
    public static function validLocales(): array
    {
        return [
            'root' => ['root', 'root'],
            'English' => ['en', 'en'],
            'Brazilian Portuguese' => ['pt-BR', 'pt-BR'],
            'French with Latin script' => ['fr-Latn', 'fr-Latn'],
            'Min Nan Chinese as spoken in Taiwan using traditional Han characters' => ['nan-Hant-TW', 'nan-Hant-TW'],
            'Klingon private' => ['x-klingon', 'x-klingon'],
            'Klingon ISO' => ['tlh', 'tlh'],
            'Arabic-language content using Basic Latin digits' => ['ar-u-nu-latn', 'ar-u-nu-latn'],
            'Hebrew in Israel, traditional Hebrew calendar, Jerusalem time zone' => ['he-IL-u-ca-hebrew-tz-jeruslm', 'he-IL-u-ca-hebrew-tz-jeruslm'],
            'German with private extension' => ['de-DE-x-foobar', 'de-DE-x-foobar'],
            'German with phonebook collation' => ['de-DE@collation=phonebook;foo=bar', 'de-DE@collation=phonebook;foo=bar'],
            'German with Posix and 1911 variant' => ['de-DE-POSIX-1911', 'de-DE-POSIX-1911'],
            'root with phonebook collation' => ['root@collation=phonebook', 'root@collation=phonebook'],
            'root only with modifier' => ['root@foo=bar', 'root@foo=bar'],
            'empty with modifier' => ['@foo=bar', 'root@foo=bar'],
            'multiple extension values' => ['en-u-ca-gregory-nu-latn', 'en-u-ca-gregory-nu-latn'],
            'numeric variant' => ['de-DE-1901', 'de-DE-1901'],
            'prefix and language' => ['x-en', 'x-en'],
            'multiple extensions' => ['en-u-ca-gregory-t-abc', 'en-u-ca-gregory-t-abc'],
            'multiple private values' => ['de-x-abc-def', 'de-x-abc-def'],
            'language length 3' => ['eng', 'eng'],
            'language length 5' => ['abcde', 'abcde'],
            'language length 8' => ['abcdefgh', 'abcdefgh'],
        ];
    }

    #[DataProvider('validLocales')]
    public function test_parses_valid_codes(string $code, string $expected): void
    {
        self::assertEquals($expected, DefaultLocale::fromString($code)->getCode());
    }

    /**
     * @return array<string, array<string>>
     */
    public static function invalidLocales(): array
    {
        return [
            'multiple @' => ['de@foo=bar@baz=qux'],
            'single character' => ['a'],
            'unresolvable parts' => ['de-x-a'],
            'invalid language' => ['dede'],
            'invalid modifier' => ['de@foo'],
            'too many @' => ['de@foo=bar@baz=qux'],
            'prefix without language' => ['x-'],
            'separator mismatch' => ['de-DE@foo'],
            'invalid language length 4' => ['abcd'],
            'invalid language length 9' => ['abcdefghi'],
            'unresolvable parts after region' => ['de-DE-!'],
        ];
    }

    #[DataProvider('invalidLocales')]
    public function test_throws_exception_for_invalid_code(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);

        DefaultLocale::fromString($code);
    }

    public function test_uses_separator(): void
    {
        $locale = DefaultLocale::fromString('de_DE_x_foobar', '_');
        self::assertEquals('de_DE_x_foobar', $locale->getCode('_'));
        self::assertEquals('de/DE/x/foobar', $locale->getCode('/'));

        $locale = DefaultLocale::fromString('de-DE-x-foobar', '-');
        self::assertEquals('de_DE_x_foobar', $locale->getCode('_'));
        self::assertEquals('de/DE/x/foobar', $locale->getCode('/'));
    }

    public function test_detects_unexpected_separator(): void
    {
        self::assertEquals('x-de', DefaultLocale::fromString('x_de')->getCode());
        self::assertEquals('de-DE', DefaultLocale::fromString('de_DE')->getCode());
        self::assertEquals('de-CH-POSIX', DefaultLocale::fromString('de_CH_POSIX')->getCode());

        self::assertEquals('x-de', DefaultLocale::fromString('x/de')->getCode());
        self::assertEquals('de-DE', DefaultLocale::fromString('de/DE')->getCode());
        self::assertEquals('de-CH-POSIX', DefaultLocale::fromString('de/CH/POSIX')->getCode());
    }

    public function test_getters(): void
    {
        $locale = DefaultLocale::fromString('x-he-Latn-IL-POSIX-u-ca-hebrew-tz-jeruslm-x-abc-def@foo=bar');
        self::assertEquals('x', $locale->getPrefix());
        self::assertEquals('he', $locale->getLanguage());
        self::assertEquals('Latn', $locale->getScript());
        self::assertEquals('IL', $locale->getRegion());
        self::assertEquals(['POSIX'], $locale->getVariants());
        self::assertEquals(['u' => ['ca', 'hebrew', 'tz', 'jeruslm']], $locale->getExtensions());
        self::assertEquals(['abc', 'def'], $locale->getPrivate());
        self::assertEquals(['foo' => 'bar'], $locale->getModifiers());
    }

    public function test_get_parent(): void
    {
        $locale = DefaultLocale::fromString('de-DE');
        $locale = $locale->getParent();
        self::assertEquals('de', $locale->getCode());
        $locale = $locale->getParent();
        self::assertEquals('root', $locale->getCode());

        $locale = DefaultLocale::fromString('x-de-Latn-CH-POSIX-u-ca-hebrew-x-abc@foo=bar');
        $locale = $locale->getParent();
        self::assertEquals('x-de-Latn-CH-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        self::assertEquals('x-de-Latn-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        self::assertEquals('x-de-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        self::assertEquals('x-root-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
    }

    public function test_is_neutral(): void
    {
        self::assertTrue(DefaultLocale::fromString('de')->isNeutral());
        self::assertTrue(DefaultLocale::fromString('de-u-tz-berlin')->isNeutral());
        self::assertTrue(DefaultLocale::fromString('de@collation=phonebook')->isNeutral());

        self::assertFalse(DefaultLocale::fromString('x-de')->isNeutral());
        self::assertFalse(DefaultLocale::fromString('de-DE')->isNeutral());
        self::assertFalse(DefaultLocale::fromString('de-Latn')->isNeutral());
        self::assertFalse(DefaultLocale::fromString('de-CH-POSIX')->isNeutral());
    }

    public function test_is_root(): void
    {
        self::assertTrue(DefaultLocale::fromString('')->isRoot());
        self::assertTrue(DefaultLocale::fromString('root')->isRoot());

        self::assertFalse(DefaultLocale::fromString('de')->isRoot());
        self::assertFalse(DefaultLocale::fromString('de-DE')->isRoot());
        self::assertFalse(DefaultLocale::fromString('x-root')->isRoot());
    }
}
