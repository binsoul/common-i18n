<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see ListFormatter} interface.
 */
class DefaultListFormatter implements ListFormatter
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string[][]
     */
    private static $formats = [
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

    private function build(array $values, string $listTwoPattern, string $listStartPattern, string $listMiddlePattern, string $listEndPattern): string
    {
        $items = array_values($values);
        $count = count($items);

        switch ($count) {
            case 0:
                return '';

            case 1:
                return (string) $items[0];

            case 2:
                return $this->join($listTwoPattern, (string) $items[0], (string) $items[1]);
        }

        $result = $this->join($listStartPattern, (string) $items[0], (string) $items[1]);

        for ($i = 2; $i < $count - 1; $i++) {
            $result = $this->join($listMiddlePattern, $result, (string) $items[$i]);
        }

        return $this->join($listEndPattern, $result, (string) $items[$count - 1]);
    }

    private function join($pattern, $first, $second): string
    {
        return str_replace(['{0}', '{1}'], [$first, $second], $pattern);
    }
}
