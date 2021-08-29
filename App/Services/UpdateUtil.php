<?php

namespace App\Services;

use Telegram\Bot\Objects\Update;

trait UpdateUtil
{
    protected function isUpdateHasText(Update $update): bool
    {
        if (empty($update->getMessage())) {
            return false;
        }

        if (empty($update->getMessage()->getText())) {
            return false;
        }

        return true;
    }
}