<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Translates strings.
 */
interface Translator
{
    /**
     * @param mixed[] $variables
     */
    public function translateSingular(string $key, array $variables = []): string;

    /**
     * @param string  $key
     * @param float   $amount
     * @param mixed[] $variables
     */
    public function translatePlural($key, $amount, array $variables = []): string;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): Translator;
}
