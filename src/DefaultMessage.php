<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see Message} interface.
 */
class DefaultMessage implements Message
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string|null
     */
    private $domain;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $key, ?string $domain = null)
    {
        $this->key = $key;
        $this->domain = $domain;
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
