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
     * Returns the domain.
     */
    public function getDomain(): ?string;
}
