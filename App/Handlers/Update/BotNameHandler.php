<?php

namespace App\Handlers\Update;

use App\API\Receiver;
use App\Events\BotName\BotNameReactionFactory;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class BotNameHandler implements UpdateEventHandlerInterface
{
    private $bot_names = [
        'Κλαύδιος',
        'Πόντιος',
        'Βιεμπάτ',
        'Клавдий',
        'Понтий',
        'Въебат',
        'тим лид',
        'team lead'
    ];

    /**
     * @var BotNameReactionFactory
     */
    private $reaction_factory;

    /**
     * @var \App\API\Receiver
     */
    private $receiver;

    public function __construct(
        ?BotNameReactionFactory $reaction_factory = null,
        ?Receiver $receiver = null
    )
    {
        $this->reaction_factory = is_null($reaction_factory) ? new BotNameReactionFactory() : $reaction_factory;
        $this->receiver = is_null($receiver) ? new Receiver() : $receiver;
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @throws \Exception
     */
    protected function sendReactions(Update $update): Message
    {
        $reaction = $this->reaction_factory->getRandomReaction();
        $message = $update->getMessage();

        return $this->receiver->sendMessage(
            $message->getChat()->getId(),
            $reaction->getReaction(),
            $message->getMessageId()
        );
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function launch(Update $update): void
    {
        $this->sendReactions($update);
    }

    public function isThatEvent(Update $update): bool
    {
        if (empty($update->getMessage())) {
            return false;
        }

        if (empty($update->getMessage()->getText())) {
            return false;
        }

        $message = $update->getMessage()->getText();

        foreach ($this->bot_names as $name) {
            if (str_contains(strtolower($message), $name)) {
                return true;
            }
        }

        return false;
    }
}