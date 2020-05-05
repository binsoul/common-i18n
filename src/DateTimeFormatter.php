<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

use DateTimeInterface;

/**
 * Formats dates and times.
 */
interface DateTimeFormatter
{
    /**
     * Formats the the given datetime according to the given pattern.
     */
    public function formatPattern(DateTimeInterface $datetime, string $pattern): string;

    /**
     * Formats the given time in the standard format.
     */
    public function formatTime(DateTimeInterface $time): string;

    /**
     * Formats the given time in the standard format including seconds.
     */
    public function formatTimeWithSeconds(DateTimeInterface $time): string;

    /**
     * Formats the given date in the standard format.
     */
    public function formatDate(DateTimeInterface $date): string;

    /**
     * Formats the given date and time in the standard format.
     */
    public function formatDateTime(DateTimeInterface $datetime): string;

    /**
     * Formats the given date and time in the standard format including seconds.
     */
    public function formatDateTimeWithSeconds(DateTimeInterface $datetime): string;

    /**
     * Returns a new instance with the given locale.
     */
    public function withLocale(Locale $locale): self;
}
