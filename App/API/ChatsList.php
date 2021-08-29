<?php

namespace App\API;

use Telegram\Bot\Objects\Chat;

class ChatsList
{
    /**
     * @var \Telegram\Bot\Objects\Chat[]
     */
    private $chats = [];

    /**
     * @var \App\API\ChatsList
     */
    private static $chat_list;

    protected function __construct()
    {
    }

    public static function getInstance(): ChatsList
    {
        if (!isset(self::$chat_list)) {
            self::$chat_list = new ChatsList();
        }

        return self::$chat_list;
    }

    public function addChatToList(Chat $chat): void
    {
        $this->chats[$chat->getId()] = $chat;
    }

    /**
     * @return \Telegram\Bot\Objects\Chat[]
     * @throws \Exception
     */
    public function getChats(): array
    {
        return $this->chats;
    }

    /**
     * @throws \Exception
     */
    public function getChat(int $chat_id): Chat
    {
        if (!key_exists($chat_id, $this->chats)) {
            throw new \Exception('Chat not found');
        }

        return $this->chats[$chat_id];
    }
}