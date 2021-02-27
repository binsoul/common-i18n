<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

function message(string $key, ?string $domain = null, ?array $parameters = null, ?float $quantity = null)
{
    $result = new DefaultMessage($key, $domain);

    if ($parameters !== null && count($parameters) > 0) {
        $result = new DefaultParameterizedMessage($result, $parameters);
    }

    if ($quantity !== null) {
        $result = new DefaultPluralizedMessage($result, $quantity);
    }

    return $result;
}
