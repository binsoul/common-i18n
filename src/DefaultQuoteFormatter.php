<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Provides a default implementation of the {@see QuoteFormatter} interface.
 */
class DefaultQuoteFormatter implements QuoteFormatter
{
    protected Locale $locale;

    /**
     * @var string[][]
     */
    private static array $formats = [
        'en' => ['“', '”', '‘', '’'],
        'en-US' => ['“', '”', '‘', '’'],
        'en-GB' => ['‘', '’', '“', '”'],
        'de' => ['„', '“', '‚', '‘'],
        'de-CH' => ['«', '»', '‹', '›'],
    ];

    /**
     * @var string[]
     */
    private array $format;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?Locale $locale = null)
    {
        $this->locale = $locale ?? DefaultLocale::fromString('de-DE');

        $format = null;
        $parsedLocale = DefaultLocale::fromString($this->locale->getCode());

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

    public function primary(string|int|float|bool|null|Stringable|array $value): string|array
    {
        return $this->build($value, $this->format[0], $this->format[1]);
    }

    public function secondary(string|int|float|bool|null|Stringable|array $value): string|array
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

    protected function toString(string|int|float|bool|null|Stringable $value): string
    {
        if ($value === null) {
            return '';
        }

        return (string) $value;
    }

    /**
     * @param string|int|float|bool|null|Stringable|array<string|int|float|bool|null|Stringable> $value
     *
     * @return string|array<string>
     */
    private function build(string|int|float|bool|null|Stringable|array $value, string $start, string $end): string|array
    {
        if (is_array($value)) {
            return array_map(
                fn (bool|float|int|string|Stringable|null $item): string => $start . $this->toString($item) . $end,
                $value
            );
        }

        return $start . $this->toString($value) . $end;
    }
}
