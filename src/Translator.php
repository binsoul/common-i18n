<?php

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
     * @return mixed
     */
    public function translateSingular($key, array $variables = []);

    /**
     * @param string  $key
     * @param float   $amount
     * @param mixed[] $variables
     *
     * @return mixed
     */
    public function translatePlural($key, $amount, array $variables = []);

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return self
     */
    public function withLocale(Locale $locale);
}
