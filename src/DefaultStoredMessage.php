<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Provides a default implementation of the {@see StoredMessage} interface.
 */
readonly class DefaultStoredMessage implements StoredMessage, Stringable
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        private Message $message,
        private string $format
    ) {
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
