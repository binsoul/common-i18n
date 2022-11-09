<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a time zone.
 */
interface TimeZone
{
    public function getName(): string;
}
