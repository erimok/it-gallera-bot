<?php

namespace App\API;

use App\Services\RandomSleep;
use App\Services\SleepTimeSetter;
use Telegram\Bot\Objects\Message;

class Receiver
{
    use RandomSleep;

    /**
     * @var \Telegram\Bot\Api
     */
    private $telegram_api;

    /**
     * @var \App\API\ChatAction
     */
    private $chat_action;

    /**
     * @var SleepTimeSetter
     */
    private $sleep_time_setter;

    public function __construct(
        ?\Telegram\Bot\Api $api = null,
        ?ChatAction $chat_action = null,
        ?SleepTimeSetter $sleep_time_setter = null
    )
    {
        $this->telegram_api = is_null($api) ? API::getInstance()->getTelegramApi() : $api;
        $this->chat_action = is_null($chat_action) ? new ChatAction() : $chat_action;
        $this->sleep_time_setter = is_null($sleep_time_setter) ? new SleepTimeSetter() : $sleep_time_setter;
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function sendMessage(string $chat_id, string $message, ?string $reply_to_message_id = null): Message
    {
        $this->chat_action->send($chat_id);
        $this->sleep_time_setter->sleepByStringLength($message);

        $params = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        if ($reply_to_message_id) {
            $params['reply_to_message_id'] = $reply_to_message_id;
        }

        return $this->telegram_api->sendMessage($params);
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function sendSticker(string $chat_id, string $sticker, ?string $reply_to_message_id = null): Message
    {
        $params = [
            'chat_id' => $chat_id,
            'sticker' => $sticker
        ];

        if ($reply_to_message_id) {
            $params['reply_to_message_id'] = $reply_to_message_id;
        }

        return $this->telegram_api->sendSticker($params);
    }
}