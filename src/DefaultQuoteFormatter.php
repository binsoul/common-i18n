<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see QuoteFormatter} interface.
 */
class DefaultQuoteFormatter implements QuoteFormatter
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string[][]
     */
    private static $formats = [
        'en' => ['“', '”', '‘', '’'],
        'en-US' => ['“', '”', '‘', '’'],
        'en-GB' => ['‘', '’', '“', '”'],
        'de' => ['„', '“', '‚', '‘'],
        'de-CH' => ['«', '»', '‹', '›'],
    ];

    /**
     * @var string[][]
     */
    private $format;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?Locale $locale = null)
    {
        $this->locale = $locale ?? DefaultLocale::fromString('de-DE');

        $format = null;
        $parsedLocale = DefaultLocale::fromString($locale->getCode());

        while (! $parsedLocale->isRoot()) {
            if (isset(self::$formats[$parsedLocale->getCode()])) {
                $format = self::$formats[$parsedLocale->getCode()];

                break;
            }

            $parsedLocale = $parsedLocale->getParent();
        }

        if ($format === null) {
            $format = self::$formats['en'];
        }

        $this->format = $format;
    }

    public function primary($value)
    {
        return $this->build($value, $this->format[0], $this->format[1]);
    }

    public function secondary($value)
    {
        return $this->build($value, $this->format[2], $this->format[3]);
    }

    public function withLocale(Locale $locale): QuoteFormatter
    {
        if ($locale->getCode() === $this->locale->getCode()) {
            return $this;
        }

        return new self($locale);
    }

    private function build($value, string $start, string $end)
    {
        if (is_array($value)) {
            $result = $value;

            foreach ($result as $index => $item) {
                $result[$index] = $this->build($item, $start, $end);
            }

            return $result;
        }

        return $start . ((string) $value) . $end;
    }
}
