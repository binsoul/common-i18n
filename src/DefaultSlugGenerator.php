<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use BinSoul\Common\I18n\Transliteration\Locale\DefaultRule;
use BinSoul\Common\I18n\Transliteration\ToAsciiRule;

/**
 * Provides a default implementation of the {@see SlugGenerator} interface.
 */
class DefaultSlugGenerator implements SlugGenerator
{
    private static $specialRules = [
        '/[\pZ\pC]*+[&\|_\+]+[\pZ\pC]*/um' => '-', // convert concatenation signs to minus
        '/[\/\\\\]/' => '-', // convert slashes to minus
        '/[\pZ\pC]+/um' => '-', // convert white space to minus
    ];

    /**
     * @var Locale
     */
    protected $locale;
    /**
     * @var string
     */
    protected $language;
    /**
     * @var TransliterationRule|null
     */
    protected $localeRule;

    /**
     * @var ToAsciiRule
     */
    protected $toAsciiRule;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?Locale $locale = null)
    {
        $this->locale = $locale ?? DefaultLocale::fromString('de-DE');

        if ($this->locale instanceof ParsedLocale) {
            $language = $this->locale->getLanguage();
        } else {
            $language = DefaultLocale::fromString($this->locale->getCode())->getLanguage();
        }

        $localeRule = str_replace('DefaultRule', ucfirst($language).'Rule', DefaultRule::class);
        if (class_exists($localeRule)) {
            $this->localeRule = new $localeRule();
        }

        $this->toAsciiRule = new ToAsciiRule();
    }

    public function transliterate(string $text, array $rules = []): string
    {
        if ($this->localeRule !== null) {
            array_unshift($rules, $this->localeRule);
        } else {
            array_unshift($rules, new DefaultRule());
        }

        $result = trim($text);
        foreach ($rules as $rule) {
            $result = $rule->apply($result);
        }

        $result = $this->toAsciiRule->apply($result);

        $result = preg_replace(array_keys(self::$specialRules), array_values(self::$specialRules), $result);
        $result = preg_replace('/[^a-z0-9-]/i', '', (string) $result);
        $result = preg_replace('/[-]{2,}/', '-', (string) $result);
        $result = trim((string) $result, '-');

        return $result;
    }

    public function withLocale(Locale $locale): SlugGenerator
    {
        if ($locale->getCode() === $this->locale->getCode()) {
            return $this;
        }

        return new self($locale);
    }
}
