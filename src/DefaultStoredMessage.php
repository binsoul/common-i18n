<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see StoredMessage} interface.
 */
class DefaultStoredMessage implements StoredMessage
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $format;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(Message $message, string $format)
    {
        $this->message = $message;
        $this->format = $format;
    }

    public function __toString(): string
    {
        return $this->format;
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
        return new self($this->message->withDomain($domain), $this->format);
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
