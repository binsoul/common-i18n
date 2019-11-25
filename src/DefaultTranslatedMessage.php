<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see TranslatedMessage} interface.
 */
class DefaultTranslatedMessage extends DefaultMessage implements TranslatedMessage
{
    /**
     * @var string
     */
    private $translation;
    /**
     * @var float|null
     */
    private $quantity;
    /**
     * @var Locale
     */
    private $locale;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        string $key,
        string $format,
        string $translation,
        Locale $locale,
        array $parameters = [],
        ?string $domain = null,
        ?float $quantity = null
    ) {
        parent::__construct($key, $format, $parameters, $domain);

        $this->translation = $translation;
        $this->quantity = $quantity;
        $this->locale = $locale;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function __toString(): string
    {
        return $this->translation;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }
}
