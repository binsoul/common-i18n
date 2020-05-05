<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Translates strings.
 */
interface Translator
{
    /**
     * Translates the given message.
     *
     * @param string|Message|PluralizedMessage $key        The message key
     * @param mixed[]                          $parameters An array of parameters for the message
     * @param string|null                      $domain     The domain for the message or null to use the default
     *
     * @return TranslatedMessage The translated message
     */
    public function translate($key, array $parameters = [], ?string $domain = null): TranslatedMessage;

    /**
     * Selects the plural form of the message for the given the quantity.
     *
     * @param string|Message $key      The message key
     * @param float|int      $quantity The quantity for the message
     * @param string|null    $domain   The domain for the message or null to use the default
     *
     * @return PluralizedMessage The pluralized message
     */
    public function pluralize($key, $quantity, ?string $domain = null): PluralizedMessage;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
