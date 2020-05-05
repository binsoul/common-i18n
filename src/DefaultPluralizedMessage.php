<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see PluralizedMessage} interface.
 */
class DefaultPluralizedMessage extends DefaultMessage implements PluralizedMessage
{
    /**
     * @var float
     */
    private $quantity;

    /**
     * Constructs an instance of this class.
     *
     * @param int|float $quantity
     * @param mixed[]   $parameters
     */
    public function __construct(
        string $key,
        string $format,
        $quantity,
        array $parameters = [],
        ?string $domain = null
    ) {
        parent::__construct($key, $format, $parameters, $domain);

        $this->quantity = (float) $quantity;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
