<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultMessage;
use BinSoul\Common\I18n\DefaultParameterizedMessage;
use BinSoul\Common\I18n\DefaultPluralizedMessage;
use BinSoul\Common\I18n\DefaultTranslator;
use BinSoul\Common\I18n\Locale;
use BinSoul\Common\I18n\StoredMessage;
use PHPUnit\Framework\TestCase;

class DefaultTranslatorTest extends TestCase
{
    public function test_translates_strings(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = $translator->translate('test', ['a' => 'b'], 'domain');

        self::assertEquals('test', $message->getKey());
        self::assertEquals('test', $message->getTranslation());
        self::assertEquals(['a' => 'b'], $message->getParameters());
        self::assertEquals('domain', $message->getDomain());
        self::assertNull($message->getQuantity());
    }

    public function test_translates_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultParameterizedMessage(new DefaultMessage('test', 'domain'), ['a' => 'b']);
        $message = $translator->translate($message);

        self::assertEquals('test', $message->getKey());
        self::assertEquals('test', $message->getTranslation());
        self::assertEquals(['a' => 'b'], $message->getParameters());
        self::assertEquals('domain', $message->getDomain());
        self::assertNull($message->getQuantity());
    }

    public function test_translates_pluralized_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultPluralizedMessage(new DefaultMessage('test'), 1.5);
        $message = $translator->translate($message, ['a' => 'b'], 'domain');

        self::assertEquals('test', $message->getKey());
        self::assertEquals('test', $message->getTranslation());
        self::assertEquals(['a' => 'b'], $message->getParameters());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals(1.5, $message->getQuantity());
    }

    public function test_pluralizes_strings(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = $translator->pluralize('test', 1.5);

        self::assertEquals('test', $message->getKey());
        self::assertEquals(1.5, $message->getQuantity());
    }

    public function test_pluralizes_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultParameterizedMessage(new DefaultMessage('test', 'domain'), ['a' => 'b']);
        $message = $translator->pluralize($message, 1.5);

        self::assertEquals('test', $message->getKey());
        self::assertEquals(1.5, $message->getQuantity());
        self::assertEquals('domain', $message->getDomain());
    }

    public function test_uses_default_locale(): void
    {
        $translator = new DefaultTranslator();
        $message = $translator->translate('test');

        self::assertInstanceOf(Locale::class, $message->getLocale());
    }

    public function test_returns_instance_with_new_locale(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $sameTranslator = $translator->withLocale(DefaultLocale::fromString('de-DE'));
        self::assertEquals($translator, $sameTranslator);

        $translator = $translator->withLocale(DefaultLocale::fromString('en-US'));
        $message = $translator->translate('test');

        self::assertEquals('en-US', $message->getLocale()->getCode());
    }

    public function test_translates_stored_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $storedMessage = $this->createStub(StoredMessage::class);
        $storedMessage->method('getFormat')->willReturn('format');
        $storedMessage->method('getKey')->willReturn('key');

        $translated = $translator->translate($storedMessage);
        self::assertEquals('format', $translated->getTranslation());

        $translatedWithParams = $translator->translate($storedMessage, ['a' => 'b']);
        self::assertEquals('format', $translatedWithParams->getTranslation());
    }

    public function test_translates_message_with_domain(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $message = new DefaultMessage('key', 'original-domain');

        $translated = $translator->translate($message, [], 'new-domain');
        self::assertEquals('new-domain', $translated->getDomain());
    }

    public function test_pluralizes_pluralized_messages(): void
    {
        $translator = new DefaultTranslator(DefaultLocale::fromString('de-DE'));
        $pluralized = new DefaultPluralizedMessage(new DefaultMessage('key', 'domain'), 1);

        $newPluralized = $translator->pluralize($pluralized, 2, 'new-domain');
        self::assertEquals(2, $newPluralized->getQuantity());
        self::assertEquals('new-domain', $newPluralized->getDomain());
    }
}
