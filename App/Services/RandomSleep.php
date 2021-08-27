<?php

namespace App\Services;

class RandomSleep
{
    /**
     * @codeCoverageIgnore
     */
    public static function sleep(): void
    {
        sleep(rand(2,5));
    }
}