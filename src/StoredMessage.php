<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a stored message.
 */
interface StoredMessage extends Message
{
    /**
     * Returns the format of the message.
     */
    public function getFormat(): string;
}
