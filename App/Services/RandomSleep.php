<?php

namespace App\Services;

/**
 * @deprecated
 */
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