<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultSlugGenerator;
use BinSoul\Common\I18n\Locale;
use BinSoul\Common\I18n\Transliteration\LowercaseRule;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_works_with_generic_locale_interface(): void
    {
        $locale = $this->createStub(Locale::class);
        $locale->method('getCode')->willReturn('de-DE');

        $generator = new DefaultSlugGenerator($locale);
        self::assertEquals('Aeae-Oeoe-Ueue', $generator->transliterate('Ää! Öö! Üü!'));
    }

    public function test_falls_back_to_default_rule(): void
    {
        $generator = new DefaultSlugGenerator(DefaultLocale::fromString('zz-YY'));
        // zz-YY doesn't have a specific rule but should fallback to DefaultRule
        self::assertEquals('a-ae-Ubermensch', $generator->transliterate('a æ Übérmensch'));
    }

    /**
     * @return array<string, array<string>>
     */
    public static function localizedRuleSamples(): array
    {
        return [
            'Danish' => ['da-DK', 'Æble Øks Århus', 'Aeble-Oeks-Aarhus'],
            'Finnish' => ['fi-FI', 'Ääliö Öljy', 'Aalio-Oljy'],
            'Norwegian Bokmål' => ['nb-NO', 'Ærlig Øy Ånd', 'AErlig-OEy-AAnd'],
            'Swedish' => ['sv-SE', 'Äta Åka Öl', 'Ata-aka-Ol'],
            'Italian' => ['it-IT', 'Caffè è più', 'Caffe-e-piu'],
            'Polish' => ['pl-PL', 'Zażółć gęślą jaźń', 'Zazolc-gesla-jazn'],
            'Czech' => ['cs-CZ', 'Příliš žluťoučký kůň', 'Prilis-zlutoucky-kun'],
            'Russian' => ['ru-RU', 'Съешь ещё этих мягких французских булок', 'Sesh-eshche-etih-myagkih-francuzskih-bulok'],
            'French' => ['fr-FR', "Œuvre d'art à l'école æthérique", 'OEuvre-art-a-lecole-aetherique'],
        ];
    }

    #[DataProvider('localizedRuleSamples')]
    public function test_localized_rules(string $code, string $text, string $expected): void
    {
        $generator = new DefaultSlugGenerator(DefaultLocale::fromString($code));
        self::assertEquals($expected, $generator->transliterate($text));
    }
}
