<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Represents a translated message.
 */
interface TranslatedMessage extends Message
{
    /**
     * Returns the translation.
     */
    public function __toString(): string;

    /**
     * Returns the translation.
     */
    public function getTranslation(): string;

    /**
     * Returns the parameters of the message or null if no parameters were used.
     *
     * @return mixed[]|null
     */
    public function getParameters(): ?array;

    /**
     * Returns the quantity used for the message or null if no quantity was used.
     */
    public function getQuantity(): ?float;

    /**
     * Returns the locale of the message.
     */
    public function getLocale(): Locale;
}
