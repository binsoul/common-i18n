<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Parses locale codes end returns {@see ParsedLocale} interfaces.
 */
interface LocaleParser
{
    /**
     * Parses the given code and returns a new instance.
     */
    public static function fromString(string $code, string $separator = '-'): ParsedLocale;
}
