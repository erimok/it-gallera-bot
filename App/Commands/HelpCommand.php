<?php

namespace App\Commands;

use App\Bot;
use Telegram\Bot\Objects\Update;

class HelpCommand extends Command
{
    const NAME = 'help';

    /**
     * @var string[]
     */
    protected $messages = [
        "Что умеет бот:<pre>\n</pre>" .
        "/start - Знакомство с ботом и его историей<pre>\n</pre>" .
        "/help - Узнать возможности бота<pre>\n</pre>" .
        '<i>Версия бота ' . Bot::VERSION . '</i>'
    ];

    protected $sticker_id = 'CAACAgIAAxkBAAIBkGEqSBxjE1C1B8x63kDg1sWc54ZuAALfAAMlA1IPc5bAOm58pPggBA';

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function launch(Update $update): void
    {
        $chat_id = $update->getMessage()->getChat()->getId();

        if (!empty($this->sticker_id)) {
            $this->receiver->sendSticker($chat_id, $this->sticker_id);
        }

        if (!empty($this->messages)) {
            foreach ($this->messages as $message) {
                $this->receiver->sendMessage($chat_id, $message);
            }
        }
    }
}