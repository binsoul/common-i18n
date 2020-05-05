<?php

declare(strict_types=1);

namespace BinSoul\Test\Common\I18n;

use BinSoul\Common\I18n\DefaultTimeZone;
use PHPUnit\Framework\TestCase;

class DefaultTimeZoneTest extends TestCase
{
    public function test_getters(): void
    {
        $timeZone = new DefaultTimeZone('Europe/Berlin');
        $this->assertEquals('Europe/Berlin', $timeZone->getName());
    }

    public function test_reads_default_time_zone(): void
    {
        $currentTimeZone = date_default_timezone_get();
        $timeZone = new DefaultTimeZone();
        $this->assertEquals($currentTimeZone, $timeZone->getName());

        date_default_timezone_set('Europe/Berlin');
        $timeZone = new DefaultTimeZone();
        $this->assertEquals('Europe/Berlin', $timeZone->getName());

        date_default_timezone_set('America/New_York');
        $timeZone = new DefaultTimeZone();
        $this->assertEquals('America/New_York', $timeZone->getName());

        date_default_timezone_set($currentTimeZone);
    }
}
