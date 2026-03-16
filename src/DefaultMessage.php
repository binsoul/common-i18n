<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Provides a default implementation of the {@see Message} interface.
 */
readonly class DefaultMessage implements Message, Stringable
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        private string $key,
        private ?string $domain = null
    ) {
    }

    public function __toString(): string
    {
        return $this->key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function withDomain(?string $domain): Message
    {
        return new self($this->key, $domain);
    }
}
