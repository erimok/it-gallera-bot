<?php

namespace App\API;

use Telegram\Bot\TelegramResponse;

class ChatAction
{
    const TYPING = 'typing';
    const UPLOAD_PHOTO = 'upload_photo';
    const RECORD_VIDEO = 'record_video';
    const UPLOAD_VIDEO = 'upload_video';
    const RECORD_VOICE = 'record_voice';
    const UPLOAD_VOICE = 'upload_voice';
    const UPLOAD_DOCUMENT = 'upload_document';
    const FIND_LOCATION = 'find_location';
    const RECORD_VIDEO_NOTE = 'record_video_note';
    const UPLOAD_VIDEO_NOTE = 'upload_video_note';

    /**
     * @var \Telegram\Bot\Api
     */
    private $telegram_api;

    public function __construct(?\Telegram\Bot\Api $telegram_api = null)
    {
        $this->telegram_api = is_null($telegram_api) ? API::getInstance()->getTelegramApi() : $telegram_api;
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @throws \Exception
     * @codeCoverageIgnore
     */
    public function send(string $chat_id, string $action = 'typing'): TelegramResponse
    {
        return $this->telegram_api->sendChatAction([
            'chat_id' => $chat_id,
            'action' => 'typing'
        ]);
    }
}