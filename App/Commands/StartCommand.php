<?php

namespace App\Commands;

use Telegram\Bot\Objects\Update;

final class StartCommand extends Command
{
    const NAME = 'start';

    /**
     * @var string[]
     */
    protected $messages = [
        'Здарова, офисный планктон!',
        'Меня зовут <b>Κλαύδιος Πόντιος Βιεμπάτ</b> (Клавдий Понтий Въебат)',
        'Отные я тим лид на Вашей галере.',
        'У меня богатый опыт управления: не один десяток лет управлял спартанской галерой!',
        'За время службы на спратанском флоте я получил прозвище от своих рабов - самый тяжелый хлыст Пиренейского полуострова',
    ];

    /**
     * @var string
     */
    protected $sticker_id = 'CAACAgIAAxkBAAMWYR6WwHM6vqRtfAixSOSXB38IqxYAAr4AAyUDUg8KwNGmBAnC8SAE';

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @codeCoverageIgnore
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