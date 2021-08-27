<?php

namespace App\Commands;

use App\API\Receiver;
use Telegram\Bot\Objects\Update;

final class StartCommand implements CommandInterface
{
    const NAME = 'start';

    /**
     * @var string[]
     */
    private $messages = [
        'Здарова, офисный планктон!',
        'Меня зовут <b>Κλαύδιος Πόντιος Βιεμπάτ</b> (Клавдий Понтий Въебат)',
        'Отные я тим лид на Вашей галере.',
        'У меня богатый опыт управления: не один десяток лет управлял спартанской галерой!',
        'За время службы на спратанском флоте я получил прозвище от своих рабов - самый тяжелый хлыст Пиренейского полуострова',
    ];

    /**
     * @var string
     */
    private $sticker_id = 'CAACAgIAAxkBAAMWYR6WwHM6vqRtfAixSOSXB38IqxYAAr4AAyUDUg8KwNGmBAnC8SAE';

    /**
     * @var \App\API\Receiver
     */
    private $receiver;

    public function __construct(?Receiver $receiver)
    {
        $this->receiver = is_null($receiver) ? new Receiver() : $receiver;
    }

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
                sleep(1);
            }
        }
    }

    public function isThatCommand(string $message_text): bool
    {
        return ltrim($message_text, $message_text[0]) === self::NAME;
    }
}