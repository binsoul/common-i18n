<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see Translator} interface, which returns the message key as translation.
 */
class DefaultTranslator implements Translator
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?Locale $locale = null)
    {
        $this->locale = $locale ?? DefaultLocale::fromString('de-DE');
    }

    public function translate($key, array $parameters = [], ?string $domain = null): TranslatedMessage
    {
        if ($key instanceof StoredMessage) {
            return new DefaultTranslatedMessage(
                $key,
                $key->getFormat(),
                $this->locale,
            );
        }

        if ($key instanceof Message) {
            return new DefaultTranslatedMessage(
                $key,
                $key->getKey(),
                $this->locale,
            );
        }

        return new DefaultTranslatedMessage(new DefaultMessage($key, $domain), $key, $this->locale);
    }

    public function pluralize($key, $quantity, ?string $domain = null): PluralizedMessage
    {
        if ($key instanceof PluralizedMessage) {
            return new DefaultPluralizedMessage(new DefaultMessage($key->getKey(), $domain ?? $key->getDomain()), $quantity);
        }

        if ($key instanceof Message) {
            return new DefaultPluralizedMessage($key, $quantity);
        }

        return new DefaultPluralizedMessage(new DefaultMessage($key, $domain), $quantity);
    }

    public function withLocale(Locale $locale): Translator
    {
        if ($locale->getCode() === $this->locale->getCode()) {
            return $this;
        }

        return new self($locale);
    }
}
