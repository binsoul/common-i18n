<?php

namespace BinSoul\Common\I18n;

/**
 * Formats dates and times.
 */
interface DateTimeFormatter
{
    /**
     * Formats the the given datetime according to the given pattern.
     *
     * @param \DateTimeInterface $datetime
     * @param string             $pattern
     *
     * @return string
     */
    public function formatPattern(\DateTimeInterface $datetime, $pattern);

    /**
     * Formats the given time in the standard format.
     *
     * @param \DateTimeInterface $time
     *
     * @return string
     */
    public function formatTime(\DateTimeInterface $time);

    /**
     * Formats the given time in the standard format including seconds.
     *
     * @param \DateTimeInterface $time
     *
     * @return string
     */
    public function formatTimeWithSeconds(\DateTimeInterface $time);

    /**
     * Formats the given date in the standard format.
     *
     * @param \DateTimeInterface $date
     *
     * @return string
     */
    public function formatDate(\DateTimeInterface $date);

    /**
     * Formats the given date and time in the standard format.
     *
     * @param \DateTimeInterface $datetime
     *
     * @return string
     */
    public function formatDateTime(\DateTimeInterface $datetime);

    /**
     * Formats the given date and time in the standard format including seconds.
     *
     * @param \DateTimeInterface $datetime
     *
     * @return string
     */
    public function formatDateTimeWithSeconds(\DateTimeInterface $datetime);

    /**
     * Returns a new instance with the given locale.
     *
     * @param Locale $locale
     *
     * @return self
     */
    public function withLocale(Locale $locale);
}
