<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides detailed information about a locale.
 */
interface ParsedLocale extends Locale
{
    /**
     * Returns the prefix.
     *
     * @return string
     */
    public function getPrefix(): string;

    /**
     * Returns the language.
     *
     * @return string
     */
    public function getLanguage(): string;

    /**
     * Returns the script.
     *
     * @return string
     */
    public function getScript(): string;

    /**
     * Returns the region.
     *
     * @return string
     */
    public function getRegion(): string;

    /**
     * Returns the variant.
     *
     * @return string[]
     */
    public function getVariants(): array;

    /**
     * Returns the extensions.
     *
     * @return string[][]
     */
    public function getExtensions(): array;

    /**
     * Returns the private tags.
     *
     * @return string[]
     */
    public function getPrivate(): array;

    /**
     * Returns the modifiers.
     *
     * @return string[]
     */
    public function getModifiers(): array;

    /**
     * Returns the parent locale.
     *
     * @return ParsedLocale
     */
    public function getParent(): ParsedLocale;

    /**
     * Indicates if the locale is the root locale.
     *
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * Indicates if the locale only contains a language.
     *
     * @return bool
     */
    public function isNeutral(): bool;
}
