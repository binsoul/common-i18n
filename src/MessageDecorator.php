<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a message decorator.
 */
interface MessageDecorator
{
    /**
     * Returns the decorated message.
     */
    public function getDecoratedMessage(): Message;
}
