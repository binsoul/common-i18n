<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Provides a default implementation of the {@see PluralizedMessage} interface.
 */
readonly class DefaultPluralizedMessage implements PluralizedMessage, MessageDecorator, Stringable
{
    private float $quantity;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        private Message $message,
        int|float $quantity
    ) {
        $this->quantity = (float) $quantity;
    }

    public function __toString(): string
    {
        return $this->message->getKey();
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
        return new self($this->message->withDomain($domain), $this->quantity);
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getDecoratedMessage(): Message
    {
        return $this->message;
    }
}
