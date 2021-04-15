<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultSlugGenerator;
use BinSoul\Common\I18n\Transliteration\LowercaseRule;
use PHPUnit\Framework\TestCase;

class DefaultSlugGeneratorTest extends TestCase
{
    public function test_generates_generic_slugs(): void
    {
        $generator = new DefaultSlugGenerator(new DefaultLocale());
        self::assertEquals('Aa-Oo-Uu', $generator->transliterate('Ää! Öö! Üü!'));
        self::assertEquals('A-ae-Ubermensch-paa-hoeyeste-nivaa-I-a-lublu-PHP-est-fi', $generator->transliterate('"A æ Übérmensch på høyeste nivå! И я люблю PHP! есть. ﬁ ¦'));

        self::assertEquals('a-b', $generator->transliterate('a+b'));
        self::assertEquals('a-b', $generator->transliterate('a&b'));
        self::assertEquals('a-b', $generator->transliterate('a & b'));
        self::assertEquals('a-b', $generator->transliterate('a/b'));
    }

    public function test_generates_localized_slugs(): void
    {
        $generator = new DefaultSlugGenerator(DefaultLocale::fromString('de-DE'));
        self::assertEquals('Aeae-Oeoe-Ueue', $generator->transliterate('Ää! Öö! Üü!'));
        self::assertEquals('A-ae-Uebermensch-paa-hoeyeste-nivaa-I-a-lublu-PHP-est-fi', $generator->transliterate('"A æ Übérmensch på høyeste nivå! И я люблю PHP! есть. ﬁ ¦'));
    }

    public function test_uses_supplied_rules(): void
    {
        $generator = new DefaultSlugGenerator(DefaultLocale::fromString('de-DE'));
        self::assertEquals('aeae-oeoe-ueue', $generator->transliterate('Ää! Öö! Üü!', [new LowercaseRule()]));
        self::assertEquals('a-ae-uebermensch-paa-hoeyeste-nivaa-i-a-lublu-php-est-fi', $generator->transliterate('"A æ Übérmensch på høyeste nivå! И я люблю PHP! есть. ﬁ ¦', [new LowercaseRule()]));
    }

    public function test_returns_instance_with_new_locale(): void
    {
        $generator = new DefaultSlugGenerator(DefaultLocale::fromString('en-US'));
        $sameGnerator = $generator->withLocale(DefaultLocale::fromString('en-US'));
        self::assertEquals($generator, $sameGnerator);

        $generator = $generator->withLocale(DefaultLocale::fromString('de-DE'));
        self::assertEquals('Aeae-Oeoe-Ueue', $generator->transliterate('Ää! Öö! Üü!'));
    }
}
