<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultMessage;
use BinSoul\Common\I18n\DefaultPluralizedMessage;
use BinSoul\Common\I18n\DefaultTranslator;
use BinSoul\Common\I18n\Locale;
use PHPUnit\Framework\TestCase;

class DefaultTranslatorTest extends TestCase
{
    public function test_translates_strings(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = $translator->translate('test', ['a' => 'b'], 'domain');

        $this->assertEquals('test', $message->getKey());
        $this->assertEquals('test', $message->getFormat());
        $this->assertEquals('test', $message->getTranslation());
        $this->assertEquals(['a' => 'b'], $message->getParameters());
        $this->assertEquals('domain', $message->getDomain());
        $this->assertNull($message->getQuantity());
    }

    public function test_translates_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultMessage('test', 'format', ['a' => 'b'], 'domain');
        $message = $translator->translate($message);

        $this->assertEquals('test', $message->getKey());
        $this->assertEquals('format', $message->getFormat());
        $this->assertEquals('test', $message->getTranslation());
        $this->assertEquals(['a' => 'b'], $message->getParameters());
        $this->assertEquals('domain', $message->getDomain());
        $this->assertNull($message->getQuantity());
    }

    public function test_translates_pluralized_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultPluralizedMessage('test', 'format', 1.5);
        $message = $translator->translate($message, ['a' => 'b'], 'domain');

        $this->assertEquals('test', $message->getKey());
        $this->assertEquals('format', $message->getFormat());
        $this->assertEquals('test', $message->getTranslation());
        $this->assertEquals(['a' => 'b'], $message->getParameters());
        $this->assertEquals('domain', $message->getDomain());
        $this->assertEquals(1.5, $message->getQuantity());
    }

    public function test_pluralizes_strings(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = $translator->pluralize('test', 1.5);

        $this->assertEquals('test', $message->getKey());
        $this->assertEquals('test', $message->getFormat());
        $this->assertEquals(1.5, $message->getQuantity());
    }

    public function test_pluralizes_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultMessage('test', 'format', ['a' => 'b'], 'domain');
        $message = $translator->pluralize($message, 1.5);

        $this->assertEquals('test', $message->getKey());
        $this->assertEquals('format', $message->getFormat());
        $this->assertEquals(1.5, $message->getQuantity());
        $this->assertEquals(['a' => 'b'], $message->getParameters());
        $this->assertEquals('domain', $message->getDomain());
    }

    public function test_uses_default_locale(): void
    {
        $translator = new DefaultTranslator();
        $message = $translator->translate('test');

        $this->assertInstanceOf(Locale::class, $message->getLocale());
    }

    public function test_returns_instance_with_new_locale(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $sameTranslator = $translator->withLocale(DefaultLocale::fromString('de-DE'));
        $this->assertEquals($translator, $sameTranslator);

        $translator = $translator->withLocale(DefaultLocale::fromString('en-US'));
        $message = $translator->translate('test');

        $this->assertEquals('en-US', $message->getLocale()->getCode());
    }
}
