<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a pluralized message.
 */
interface PluralizedMessage
{
    /**
     * Returns the quantity used for the message.
     */
    public function getQuantity(): float;
}
