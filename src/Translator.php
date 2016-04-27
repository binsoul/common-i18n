<?php

declare (strict_types = 1);

namespace BinSoul\Common\I18n;

/**
 * Translates strings.
 */
interface Translator
{
    /**
     * @param string  $key
     * @param mixed[] $variables
     *
     * @return string
     */
    public function translateSingular(string $key, array $variables = []): string;

    /**
     * @param string  $key
     * @param float   $amount
     * @param mixed[] $variables
     *
     * @return string
     */
    public function translatePlural($key, $amount, array $variables = []): string;

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return Translator
     */
    public function withLocale(Locale $locale): Translator;
}
