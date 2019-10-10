<?php

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
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
    public function test_parses_valid_codes($code)
    {
        $this->assertEquals($code, DefaultLocale::fromString($code)->getCode());
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
    public function test_throws_exception_for_invalid_code($code)
    {
        $this->expectException(\InvalidArgumentException::class);

        DefaultLocale::fromString($code);
    }

    public function test_uses_separator()
    {
        $locale = DefaultLocale::fromString('de_DE_x_foobar', '_');
        $this->assertEquals('de_DE_x_foobar', $locale->getCode('_'));
        $this->assertEquals('de/DE/x/foobar', $locale->getCode('/'));

        $locale = DefaultLocale::fromString('de-DE-x-foobar', '-');
        $this->assertEquals('de_DE_x_foobar', $locale->getCode('_'));
        $this->assertEquals('de/DE/x/foobar', $locale->getCode('/'));
    }

    public function test_getters()
    {
        $locale = DefaultLocale::fromString('x-he-Latn-IL-POSIX-u-ca-hebrew-tz-jeruslm-x-abc-def@foo=bar');
        $this->assertEquals('x', $locale->getPrefix());
        $this->assertEquals('he', $locale->getLanguage());
        $this->assertEquals('Latn', $locale->getScript());
        $this->assertEquals('IL', $locale->getRegion());
        $this->assertEquals(['POSIX'], $locale->getVariants());
        $this->assertEquals(['u' => ['ca', 'hebrew', 'tz', 'jeruslm']], $locale->getExtensions());
        $this->assertEquals(['abc', 'def'], $locale->getPrivate());
        $this->assertEquals(['foo' => 'bar'], $locale->getModifiers());
    }

    public function test_get_parent()
    {
        $locale = DefaultLocale::fromString('x-de-Latn-CH-POSIX-u-ca-hebrew-x-abc@foo=bar');
        $locale = $locale->getParent();
        $this->assertEquals('x-de-Latn-CH-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        $this->assertEquals('x-de-Latn-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        $this->assertEquals('x-de-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
        $locale = $locale->getParent();
        $this->assertEquals('x-root-u-ca-hebrew-x-abc@foo=bar', $locale->getCode());
    }

    public function test_is_neutral()
    {
        $this->assertTrue(DefaultLocale::fromString('de')->isNeutral());
        $this->assertTrue(DefaultLocale::fromString('de-u-tz-berlin')->isNeutral());
        $this->assertTrue(DefaultLocale::fromString('de@collation=phonebook')->isNeutral());

        $this->assertFalse(DefaultLocale::fromString('x-de')->isNeutral());
        $this->assertFalse(DefaultLocale::fromString('de-DE')->isNeutral());
        $this->assertFalse(DefaultLocale::fromString('de-Latn')->isNeutral());
        $this->assertFalse(DefaultLocale::fromString('de-CH-POSIX')->isNeutral());
    }

    public function test_is_root()
    {
        $this->assertTrue(DefaultLocale::fromString('')->isRoot());
        $this->assertTrue(DefaultLocale::fromString('root')->isRoot());

        $this->assertFalse(DefaultLocale::fromString('de')->isRoot());
        $this->assertFalse(DefaultLocale::fromString('de-DE')->isRoot());
        $this->assertFalse(DefaultLocale::fromString('x-root')->isRoot());
    }
}
