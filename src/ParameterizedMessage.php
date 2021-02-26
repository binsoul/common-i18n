<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a parameterized message.
 */
interface ParameterizedMessage
{
    /**
     * Returns the parameters of the message.
     *
     * @return mixed[]
     */
    public function getParameters(): array;
}
