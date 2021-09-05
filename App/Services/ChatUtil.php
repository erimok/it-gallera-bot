<?php

namespace App\Services;

use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Message;

trait ChatUtil
{
    public function getChatFromMessage(?Message $message = null): ?Chat
    {
        if (is_null($message)) {
            return null;
        }

        return $message->getChat();
    }
}