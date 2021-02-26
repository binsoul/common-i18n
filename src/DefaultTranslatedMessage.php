<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see TranslatedMessage} interface.
 */
class DefaultTranslatedMessage implements TranslatedMessage, MessageDecorator
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $translation;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(Message $message, string $translation, Locale $locale)
    {
        $this->message = $message;
        $this->translation = $translation;
        $this->locale = $locale;
    }

    public function __toString(): string
    {
        return $this->translation;
    }

    public function getKey(): string
    {
        return $this->message->getKey();
    }

    public function getDomain(): ?string
    {
        return $this->message->getDomain();
    }

    public function withDomain(?string $domain): Message
    {
        return new self($this->message->withDomain($domain), $this->translation, $this->locale);
    }

    public function getParameters(): ?array
    {
        if ($this->message instanceof ParameterizedMessage) {
            return $this->message->getParameters();
        }

        $message = $this->message;

        while ($message instanceof MessageDecorator) {
            $message = $message->getDecoratedMessage();

            if ($message instanceof ParameterizedMessage) {
                return $message->getParameters();
            }
        }

        return null;
    }

    public function getQuantity(): ?float
    {
        if ($this->message instanceof PluralizedMessage) {
            return $this->message->getQuantity();
        }

        $message = $this->message;

        while ($message instanceof MessageDecorator) {
            $message = $message->getDecoratedMessage();

            if ($message instanceof PluralizedMessage) {
                return $message->getQuantity();
            }
        }

        return null;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getDecoratedMessage(): Message
    {
        return $this->message;
    }
}
