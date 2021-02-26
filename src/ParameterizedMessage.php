<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a parameterized message.
 */
interface ParameterizedMessage extends Message
{
    /**
     * Returns the parameters of the message.
     *
     * @return mixed[]
     */
    public function getParameters(): array;
}
