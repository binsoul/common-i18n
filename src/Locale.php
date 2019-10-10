<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a BCP 47 language tag extended with POSIX modifiers.
 */
interface Locale
{
    /**
     * Parses the given code and returns a new instance.
     *
     * @param string $code
     * @param string $separator
     *
     * @return Locale
     */
    public static function fromString(string $code, string $separator = '-'): Locale;

    /**
     * Returns the complete code.
     *
     * @param string $separator
     *
     * @return string
     */
    public function getCode(string $separator = '-'): string;

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
     * @return Locale
     */
    public function getParent(): Locale;

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
