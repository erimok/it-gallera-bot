<?php

namespace App\Services;

trait RandomSleep
{
    /**
     * @codeCoverageIgnore
     */
    public function sleep(): void
    {
        sleep(rand(2,5));
    }
}