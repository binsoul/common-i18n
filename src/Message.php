<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a message.
 */
interface Message
{
    /**
     * Returns the key.
     */
    public function getKey(): string;

    /**
     * Returns the format of the message.
     */
    public function getFormat(): string;

    /**
     * Returns the parameters of the message.
     *
     * @return mixed[]
     */
    public function getParameters(): array;

    /**
     * Returns the domain.
     */
    public function getDomain(): ?string;
}
