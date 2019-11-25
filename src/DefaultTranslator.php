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
        $this->locale = $locale;
        if ($this->locale === null) {
            $this->locale = DefaultLocale::fromString('de-DE');
        }
    }

    public function translate($key, array $parameters = [], ?string $domain = null): TranslatedMessage
    {
        if ($key instanceof PluralizedMessage) {
            return new DefaultTranslatedMessage(
                $key->getKey(),
                $key->getFormat(),
                $key->getKey(),
                $this->locale,
                $parameters,
                $domain,
                $key->getQuantity()
            );
        }

        if ($key instanceof Message) {
            return new DefaultTranslatedMessage(
                $key->getKey(),
                $key->getFormat(),
                $key->getKey(),
                $this->locale,
                array_merge($key->getParameters(), $parameters),
                $domain ?? $key->getDomain()
            );
        }

        return new DefaultTranslatedMessage($key, $key, $key, $this->locale, $parameters, $domain);
    }

    public function pluralize($key, $quantity): PluralizedMessage
    {
        if ($key instanceof Message) {
            return new DefaultPluralizedMessage(
                $key->getKey(),
                $key->getFormat(),
                $quantity,
                $key->getParameters(),
                $key->getDomain()
            );
        }

        return new DefaultPluralizedMessage($key, $key, $quantity);
    }

    public function withLocale(Locale $locale): Translator
    {
        if ($locale->getCode() === $this->locale->getCode()) {
            return $this;
        }

        return new DefaultTranslator($locale);
    }
}
