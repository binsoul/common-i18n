<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a currency.
 */
interface Currency
{
    /**
     * Returns the ISO3 code.
     */
    public function getIso3(): string;
}
