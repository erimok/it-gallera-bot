<?php

namespace App\Handlers\Update;

use Telegram\Bot\Objects\Update;

interface UpdateEventHandlerInterface
{
    public function launch(Update $update): void;

    public function isThatEvent(Update $update): bool;
}