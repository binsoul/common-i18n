<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultLocale;
use BinSoul\Common\I18n\DefaultMessage;
use BinSoul\Common\I18n\DefaultParameterizedMessage;
use BinSoul\Common\I18n\DefaultPluralizedMessage;
use BinSoul\Common\I18n\DefaultStoredMessage;
use BinSoul\Common\I18n\DefaultTranslatedMessage;
use PHPUnit\Framework\TestCase;

class DefaultMessageTest extends TestCase
{
    public function test_default_message(): void
    {
        $message = new DefaultMessage('key', 'domain');
        self::assertEquals('key', $message->getKey());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals('key', (string) $message);

        $new = $message->withDomain('new');
        self::assertEquals('new', $new->getDomain());
        self::assertEquals('key', $new->getKey());
    }

    public function test_parameterized_message(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $params = ['foo' => 'bar'];
        $message = new DefaultParameterizedMessage($base, $params);

        self::assertEquals('key', $message->getKey());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals($params, $message->getParameters());
        self::assertEquals($base, $message->getDecoratedMessage());
        self::assertEquals('key', (string) $message);

        $new = $message->withDomain('new');
        self::assertEquals('new', $new->getDomain());
        self::assertEquals($params, $new->getParameters());
    }

    public function test_pluralized_message(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $message = new DefaultPluralizedMessage($base, 5);

        self::assertEquals('key', $message->getKey());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals(5.0, $message->getQuantity());
        self::assertEquals($base, $message->getDecoratedMessage());
        self::assertEquals('key', (string) $message);

        $new = $message->withDomain('new');
        self::assertEquals('new', $new->getDomain());
        self::assertEquals(5.0, $new->getQuantity());
    }

    public function test_stored_message(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $message = new DefaultStoredMessage($base, 'format');

        self::assertEquals('key', $message->getKey());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals('format', $message->getFormat());
        self::assertEquals('format', (string) $message);

        $new = $message->withDomain('new');
        self::assertEquals('new', $new->getDomain());
        self::assertEquals('format', $new->getFormat());
    }

    public function test_translated_message(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $locale = DefaultLocale::fromString('en-US');
        $message = new DefaultTranslatedMessage($base, 'translation', $locale);

        self::assertEquals('key', $message->getKey());
        self::assertEquals('domain', $message->getDomain());
        self::assertEquals('translation', $message->getTranslation());
        self::assertEquals('translation', (string) $message);
        self::assertEquals($locale, $message->getLocale());
        self::assertEquals($base, $message->getDecoratedMessage());

        $new = $message->withDomain('new');
        self::assertEquals('new', $new->getDomain());
    }

    public function test_translated_message_extracts_params(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $params = ['foo' => 'bar'];
        $parameterized = new DefaultParameterizedMessage($base, $params);
        $locale = DefaultLocale::fromString('en-US');

        // Direct parameterized
        $message = new DefaultTranslatedMessage($parameterized, 'translation', $locale);
        self::assertEquals($params, $message->getParameters());

        // Nested decorator
        $pluralized = new DefaultPluralizedMessage($parameterized, 1);
        $message2 = new DefaultTranslatedMessage($pluralized, 'translation', $locale);
        self::assertEquals($params, $message2->getParameters());

        // No params
        $message3 = new DefaultTranslatedMessage($base, 'translation', $locale);
        self::assertNull($message3->getParameters());
    }

    public function test_translated_message_extracts_quantity(): void
    {
        $base = new DefaultMessage('key', 'domain');
        $pluralized = new DefaultPluralizedMessage($base, 5);
        $locale = DefaultLocale::fromString('en-US');

        // Direct pluralized
        $message = new DefaultTranslatedMessage($pluralized, 'translation', $locale);
        self::assertEquals(5.0, $message->getQuantity());

        // Nested decorator
        $parameterized = new DefaultParameterizedMessage($pluralized, []);
        $message2 = new DefaultTranslatedMessage($parameterized, 'translation', $locale);
        self::assertEquals(5.0, $message2->getQuantity());

        // No quantity
        $message3 = new DefaultTranslatedMessage($base, 'translation', $locale);
        self::assertNull($message3->getQuantity());
    }

    public function test_message_helper(): void
    {
        $message = \BinSoul\Common\I18n\message('key');
        self::assertInstanceOf(DefaultMessage::class, $message);
        self::assertEquals('key', $message->getKey());

        $message = \BinSoul\Common\I18n\message('key', 'domain', ['a' => 'b']);
        self::assertInstanceOf(DefaultParameterizedMessage::class, $message);
        self::assertEquals(['a' => 'b'], $message->getParameters());

        $message = \BinSoul\Common\I18n\message('key', 'domain', null, 5);
        self::assertInstanceOf(DefaultPluralizedMessage::class, $message);
        self::assertEquals(5.0, $message->getQuantity());

        $message = \BinSoul\Common\I18n\message('key', 'domain', ['a' => 'b'], 5);
        self::assertInstanceOf(DefaultPluralizedMessage::class, $message);
        self::assertEquals(5.0, $message->getQuantity());
        self::assertInstanceOf(DefaultParameterizedMessage::class, $message->getDecoratedMessage());
    }
}
