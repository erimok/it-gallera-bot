<?php

namespace Services;

use App\Services\SleepTimeSetter;
use PHPUnit\Framework\TestCase;

class SleepTimeSetterTest extends TestCase
{

    public function testGetSleepTimeByStringLength(): void
    {
        $sleep_time_setter = new SleepTimeSetter();

        $text_up_to_10 = '12345';
        $text_up_to_15 = '1234567890';
        $text_more_than_14 = '123456789012345';

        $this->assertEquals(4, $sleep_time_setter->getSleepTimeByStringLength($text_up_to_10));
        $this->assertEquals(6, $sleep_time_setter->getSleepTimeByStringLength($text_up_to_15));
        $this->assertEquals(8, $sleep_time_setter->getSleepTimeByStringLength($text_more_than_14));
    }
}
