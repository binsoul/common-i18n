<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see PluralizedMessage} interface.
 */
class DefaultPluralizedMessage implements PluralizedMessage, MessageDecorator
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var float
     */
    private $quantity;

    /**
     * Constructs an instance of this class.
     *
     * @param int|float $quantity
     */
    public function __construct(Message $message, $quantity)
    {
        $this->message = $message;
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

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getDecoratedMessage(): Message
    {
        return $this->message;
    }
}
