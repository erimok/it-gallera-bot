<?php

namespace App\Commands;

use App\API\Receiver;
use Telegram\Bot\Objects\Update;

abstract class Command implements CommandInterface
{
    const NAME = '';

    /**
     * @var string[]
     */
    protected $messages;

    /**
     * @var string
     */
    protected $sticker_id;

    /**
     * @var \App\API\Receiver
     */
    protected $receiver;

    public function __construct(?Receiver $receiver)
    {
        $this->receiver = is_null($receiver) ? new Receiver() : $receiver;
    }

    abstract public function launch(Update $update): void;

    public function isThatCommand(string $message_text): bool
    {
        return ltrim($message_text, $message_text[0]) === self::NAME;
    }
}