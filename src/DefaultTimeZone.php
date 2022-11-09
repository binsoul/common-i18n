<?php

declare(strict_types=1);

namespace BinSoul\Common\I18n;

/**
 * Provides a default implementation of the {@see TimeZone} interface.
 */
class DefaultTimeZone implements TimeZone
{
    /**
     * @var string
     */
    private $timeZone;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(?string $timeZone = null)
    {
        $this->timeZone = (string) $timeZone;

        if ($this->timeZone === '') {
            $this->timeZone = date_default_timezone_get();
        }
    }

    public function getName(): string
    {
        return $this->timeZone;
    }
}
