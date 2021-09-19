<?php

namespace App\Commands;

use Telegram\Bot\Objects\Update;

interface CommandInterface
{
    public function launch(Update $update): void;

    public function isThatCommand(string $message_text): bool;
}