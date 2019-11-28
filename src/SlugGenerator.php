<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Generates slugs for URLs, filenames or any other target that has a limited character set.
 */
interface SlugGenerator extends Transliterator
{
    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): SlugGenerator;
}
