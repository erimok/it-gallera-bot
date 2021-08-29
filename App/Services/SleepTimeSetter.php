<?php

namespace App\Services;

class SleepTimeSetter
{
    /**
     * @param string $text
     * @codeCoverageIgnore 
     */
    public function sleepByStringLength(string $text): void
    {
        sleep(rand(2, $this->getSleepTimeByStringLength($text)));
    }

    public function getSleepTimeByStringLength(string $text): int
    {
        $string_length = strlen($text);

        switch (true) {
            case ($string_length > 0 && $string_length < 10):
                return 4;
            case ($string_length >= 10 && $string_length < 15):
                return 6;
            case ($string_length >= 15):
                return 8;
            default:
                return 5;
        }
    }
}