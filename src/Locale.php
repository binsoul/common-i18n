<?php

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
    public static function fromString($code, $separator = '-');

    /**
     * Returns the complete code.
     *
     * @param string $separator
     *
     * @return string
     */
    public function getCode($separator = '-');

    /**
     * Returns the prefix.
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Returns the language.
     *
     * @return string
     */
    public function getLanguage();

    /**
     * Returns the script.
     *
     * @return string
     */
    public function getScript();

    /**
     * Returns the region.
     *
     * @return string
     */
    public function getRegion();

    /**
     * Returns the variant.
     *
     * @return string[]
     */
    public function getVariants();

    /**
     * Returns the extensions.
     *
     * @return string[][]
     */
    public function getExtensions();

    /**
     * Returns the private tags.
     *
     * @return \string[]
     */
    public function getPrivate();

    /**
     * Returns the modifiers.
     *
     * @return \string[]
     */
    public function getModifiers();

    /**
     * Returns the parent locale.
     *
     * @return Locale
     */
    public function getParent();

    /**
     * Indicates if the locale is the root locale.
     *
     * @return bool
     */
    public function isRoot();

    /**
     * Indicates if the locale only contains a language.
     *
     * @return bool
     */
    public function isNeutral();
}
