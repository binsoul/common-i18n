<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DefaultLocaleTest extends TestCase
{
    public function validLocales()
    {
        return [
            'root' => ['root'],
            'English' => ['en'],
            'Brazilian Portuguese' => ['pt-BR'],
            'French with Latin script' => ['fr-Latn'],
            'Min Nan Chinese as spoken in Taiwan using traditional Han characters' => ['nan-Hant-TW'],
            'Klingon private' => ['x-klingon'],
            'Klingon ISO' => ['tlh'],
            'Arabic-language content using Basic Latin digits' => ['ar-u-nu-latn'],
            'Hebrew in Israel, traditional Hebrew calendar, Jerusalem time zone' => ['he-IL-u-ca-hebrew-tz-jeruslm'],
            'German with private extension' => ['de-DE-x-foobar'],
            'German with phonebook collation' => ['de-DE@collation=phonebook;foo=bar'],
            'German with Posix and 1911 variant' => ['de-DE-POSIX-1911'],
            'root with phonebook collation' => ['root@collation=phonebook'],
        ];
    }

    /**
     * @dataProvider validLocales
     */
    public function test_parses_valid_codes($code): void
    {
        self::assertEquals($code, DefaultLocale::fromString($code)->getCode());
    }

    public function invalidLocales()
    {
        return [
            'multiple @' => ['de@foo=bar@baz=qux'],
            'single character' => ['a'],
            'unresolvable parts' => ['de-x-a'],
            'invalid language' => ['dede'],
            'invalid modifier' => ['de@foo'],
        ];
    }

    /**
     * @dataProvider invalidLocales
     */
    public function test_throws_exception_for_invalid_code($code): void
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
