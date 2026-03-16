<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * @param array<string, mixed>|null $parameters
 *
 * @phpstan-return ($quantity is int|float ? DefaultPluralizedMessage : ($parameters is array ? DefaultParameterizedMessage : DefaultMessage))
 */
function message(string $key, ?string $domain = null, ?array $parameters = null, float|int|null $quantity = null): DefaultMessage|DefaultParameterizedMessage|DefaultPluralizedMessage
{
    $result = new DefaultMessage($key, $domain);

    if ($parameters !== null && $parameters !== []) {
        $result = new DefaultParameterizedMessage($result, $parameters);
    }

    if ($quantity !== null) {
        $result = new DefaultPluralizedMessage($result, $quantity);
    }

    return $result;
}
