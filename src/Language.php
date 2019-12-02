<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a language.
 */
interface Language
{
    /**
     * Returns the ISO2 code.
     */
    public function getIso2(): string;

    /**
     * Returns the ISO3 code.
     */
    public function getIso3(): string;
}
