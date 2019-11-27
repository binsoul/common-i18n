<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use InvalidArgumentException;

/**
 * Provides a default implementation of the {@see Locale}, {@see ParsedLocale} and {@see LocaleParser} interfaces.
 */
class DefaultLocale implements Locale, ParsedLocale, LocaleParser
{
    /** @var string */
    private $prefix;
    /** @var string */
    private $language;
    /** @var string */
    private $script;
    /** @var string */
    private $region;
    /** @var string[] */
    private $variants;
    /** @var string[][] */
    private $extensions;
    /** @var string[] */
    private $modifiers;
    /** @var string[] */
    private $private;

    /**
     * Constructs an instance of this class.
     *
     * @param string[]   $variants
     * @param string[]   $modifiers
     * @param string[][] $extensions
     * @param string[]   $private
     */
    public function __construct(
        string $language = 'root',
        string $region = '',
        string $script = '',
        array $variants = [],
        array $modifiers = [],
        array $extensions = [],
        array $private = [],
        string $prefix = ''
    ) {
        self::assertValidLanguage($language);

        $this->prefix = $prefix;
        $this->language = strtolower($language);
        $this->script = ucfirst($script);
        $this->region = strtoupper($region);
        $this->variants = $variants;
        $this->extensions = $extensions;
        $this->modifiers = $modifiers;
        $this->private = $private;
    }

    public static function fromString(string $code, string $separator = '-'): ParsedLocale
    {
        if ($code === '' || $code === 'root') {
            return new self('root');
        }

        $target = $code;
        $modifiers = [];

        $tags = explode('@', $code);
        if (count($tags) > 2) {
            throw new InvalidArgumentException(sprintf('Expected at most one @ but got %d in "%s".', count($tags) - 1, $code));
        }

        if (count($tags) === 2) {
            $target = $tags[0];
            $modifiers = self::parseModifiers($tags[1]);
        }

        if ($target === '' || $target === 'root') {
            return new self('root', '', '', [], $modifiers);
        }

        $tags = explode($separator, $target);
        if ($tags === false) {
            return new self('root', '', '', [], $modifiers);
        }

        $language = strtolower((string) array_shift($tags));

        if (preg_match('([^a-z])', $language, $matches)) {
            // real separator differs from the expected separator
            $separator = $matches[0];
            $tags = explode($separator, $target);
            if ($tags === false) {
                return new self('root', '', '', [], $modifiers);
            }

            $language = strtolower((string) array_shift($tags));
        }

        $prefix = '';
        if (strlen($language) === 1) {
            $prefix = $language;
            if (count($tags) === 0) {
                throw new InvalidArgumentException(sprintf('Expected at least a language code in "%s".', $code));
            }

            $language = strtolower(array_shift($tags));
        }

        if (count($tags) === 0) {
            return new self($language, '', '', [], $modifiers, [], [], $prefix);
        }

        $script = '';
        if (strlen($tags[0]) === 4) {
            $script = ucfirst(array_shift($tags));
        }

        if (count($tags) === 0) {
            return new self($language, '', $script, [], $modifiers, [], [], $prefix);
        }

        $region = '';
        if (count($tags) > 0 && preg_match('/([a-zA-Z]{2})|(\d{3})/', $tags[0])) {
            $region = strtoupper(array_shift($tags));
        }

        if (count($tags) === 0) {
            return new self($language, $region, $script, [], $modifiers, [], [], $prefix);
        }

        $variants = self::extractVariants($tags);
        $extensions = self::extractExtensions($tags);
        $private = self::extractPrivate($tags);

        if (count($tags) > 0) {
            throw new InvalidArgumentException(sprintf('Could not resolve all parts of "%s".', $code));
        }

        return new self($language, $region, $script, $variants, $modifiers, $extensions, $private, $prefix);
    }

    public function getCode(string $separator = '-'): string
    {
        $result = '';
        if ($this->prefix !== '') {
            $result .= $this->prefix.$separator;
        }

        $result .= $this->language;

        if ($this->script !== '') {
            $result .= $separator.$this->script;
        }

        if ($this->region !== '') {
            $result .= $separator.$this->region;
        }

        if (count($this->variants) > 0) {
            $result .= $separator.implode($separator, $this->variants);
        }

        if (count($this->extensions) > 0) {
            $parts = [];
            foreach ($this->extensions as $key => $values) {
                $parts[] = $key.$separator.implode($separator, $values);
            }

            $result .= $separator.implode($separator, $parts);
        }

        if (count($this->private) > 0) {
            $result .= $separator.'x'.$separator.implode($separator, $this->private);
        }

        if (count($this->modifiers) > 0) {
            $parts = [];
            foreach ($this->modifiers as $key => $value) {
                $parts[] = $key.'='.$value;
            }

            $result .= '@'.implode(';', $parts);
        }

        return $result;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getVariants(): array
    {
        return $this->variants;
    }

    public function getExtensions(): array
    {
        return $this->extensions;
    }

    public function getPrivate(): array
    {
        return $this->private;
    }

    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    public function getParent(): ParsedLocale
    {
        $result = clone $this;

        if (count($this->variants) > 0) {
            $result->variants = [];
        } elseif ($this->region !== '') {
            $result->region = '';
        } elseif ($this->script !== '') {
            $result->script = '';
        } else {
            $result->language = 'root';
        }

        return $result;
    }

    public function isRoot(): bool
    {
        return $this->prefix === '' && $this->language === 'root';
    }

    public function isNeutral(): bool
    {
        return $this->prefix === '' && $this->script === '' && $this->region === '' && count($this->variants) === 0;
    }

    /**
     * @return string[]
     */
    private static function parseModifiers(string $value): array
    {
        $result = [];
        $modifiers = explode(';', $value);
        foreach ($modifiers as $modifier) {
            $parts = explode('=', $modifier);
            if (count($parts) !== 2) {
                throw new InvalidArgumentException(sprintf('Invalid modifier "%s".', $modifier));
            }

            $result[$parts[0]] = $parts[1];
        }

        return $result;
    }

    /**
     * @param string[] $parts
     *
     * @return string[]
     */
    private static function extractVariants(array &$parts): array
    {
        $variants = [];
        while (count($parts) > 0 && preg_match('/([a-zA-Z]{5,8})|(\d[a-zA-Z0-9]{3})/', $parts[0])) {
            $part = array_shift($parts);
            if ((string) $part === '') {
                continue;
            }

            $variants[] = (string) $part;
        }

        return $variants;
    }

    /**
     * @param string[] $parts
     *
     * @return string[][]
     */
    private static function extractExtensions(array &$parts): array
    {
        $extensions = [];
        while (count($parts) > 1 && strlen($parts[0]) === 1 && strtolower($parts[0]) !== 'x') {
            $extension = array_shift($parts);
            if ((string) $extension === '') {
                continue;
            }

            $extensions[$extension] = [];
            while (count($parts) > 0 && preg_match('/([a-zA-Z]{2,8})/', $parts[0])) {
                $part = array_shift($parts);
                if ((string) $part === '') {
                    continue;
                }

                $extensions[$extension][] = (string) $part;
            }
        }

        return $extensions;
    }

    /**
     * @param string[] $parts
     *
     * @return string[]
     */
    private static function extractPrivate(array &$parts): array
    {
        $private = [];
        if (count($parts) > 1 && strtolower($parts[0]) === 'x') {
            array_shift($parts);
            while (count($parts) > 0 && preg_match('/([a-zA-Z]{2,8})/', $parts[0])) {
                $part = array_shift($parts);
                if ((string) $part === '') {
                    continue;
                }

                $private[] = (string) $part;
            }
        }

        return $private;
    }

    private static function assertValidLanguage(string $language): void
    {
        if ($language === 'root') {
            return;
        }

        $length = strlen($language);
        if (!in_array($length, [2, 3, 5, 6, 7, 8], true)) {
            throw new InvalidArgumentException(sprintf('Invalid language code in "%s".', $language));
        }
    }
}
