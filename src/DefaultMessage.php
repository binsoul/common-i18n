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
     * @var string
     */
    private $format;

    /**
     * @var mixed[]
     */
    private $parameters;

    /**
     * @var string|null
     */
    private $domain;

    /**
     * Constructs an instance of this class.
     *
     * @param mixed[] $parameters
     */
    public function __construct(
        string $key,
        string $format,
        array $parameters = [],
        ?string $domain = null
    ) {
        $this->key = $key;
        $this->format = $format;
        $this->parameters = $parameters;
        $this->domain = $domain;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }
}
