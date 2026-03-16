<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use Stringable;

/**
 * Provides a default implementation of the {@see ListFormatter} interface.
 */
class DefaultListFormatter implements ListFormatter
{
    protected Locale $locale;

    /**
     * @var array<string, array<array<string>>>
     */
    private static array $formats = [
        'en' => [
            ['{0}, {1}', '{0}, {1}', '{0}, {1}', '{0}, {1}'],
            ['{0} and {1}', '{0}, {1}', '{0}, {1}', '{0}, and {1}'],
            ['{0} or {1}', '{0}, {1}', '{0}, {1}', '{0}, or {1}'],
        ],
        'de' => [
            ['{0}, {1}', '{0}, {1}', '{0}, {1}', '{0}, {1}'],
            ['{0} und {1}', '{0}, {1}', '{0}, {1}', '{0} und {1}'],
            ['{0} oder {1}', '{0}, {1}', '{0}, {1}', '{0} oder {1}'],
        ],
    ];

    /**
     * @var array<array<string>>
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

    public function format(array $values): string
    {
        return $this->build($values, $this->format[0][0], $this->format[0][1], $this->format[0][2], $this->format[0][3]);
    }

    public function formatConjunction(array $values): string
    {
        return $this->build($values, $this->format[1][0], $this->format[1][1], $this->format[1][2], $this->format[1][3]);
    }

    public function formatDisjunction(array $values): string
    {
        return $this->build($values, $this->format[2][0], $this->format[2][1], $this->format[2][2], $this->format[2][3]);
    }

    public function withLocale(Locale $locale): ListFormatter
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
     * @param array<string|int|float|bool|null|Stringable> $values
     */
    private function build(array $values, string $listTwoPattern, string $listStartPattern, string $listMiddlePattern, string $listEndPattern): string
    {
        $items = array_values($values);
        $count = count($items);

        switch ($count) {
            case 0:
                return '';

            case 1:
                return $this->toString($items[0]);

            case 2:
                return $this->join($listTwoPattern, $this->toString($items[0]), $this->toString($items[1]));
        }

        $result = $this->join($listStartPattern, $this->toString($items[0]), $this->toString($items[1]));

        for ($i = 2; $i < $count - 1; $i++) {
            $result = $this->join($listMiddlePattern, $result, $this->toString($items[$i]));
        }

        return $this->join($listEndPattern, $result, $this->toString($items[$count - 1]));
    }

    private function join(string $pattern, string $first, string $second): string
    {
        return str_replace(['{0}', '{1}'], [$first, $second], $pattern);
    }
}
