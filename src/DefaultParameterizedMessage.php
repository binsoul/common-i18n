<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see ParameterizedMessage} interface.
 */
class DefaultParameterizedMessage implements Message, ParameterizedMessage, MessageDecorator
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var mixed[]
     */
    private $parameters;

    /**
     * Constructs an instance of this class.
     *
     * @param mixed[] $parameters
     */
    public function __construct(Message $message, array $parameters = [])
    {
        $this->message = $message;
        $this->parameters = $parameters;
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

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDecoratedMessage(): Message
    {
        return $this->message;
    }
}
