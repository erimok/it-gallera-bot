<?php

namespace API;

use App\API\ChatAction;
use App\API\Receiver;
use App\Services\SleepTimeSetter;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\TelegramResponse;

final class ReceiverTest extends TestCase
{
    /**
     * @var Receiver
     */
    protected $receiver;

    /**
     * @var \Telegram\Bot\Api
     */
    private $telegram_api;

    protected function setUp(): void
    {
        parent::setUp();

        $this->telegram_api = $this->createMock(Api::class);

        $telegram_response = $this->createMock(TelegramResponse::class);
        $chat_action = $this->getMockBuilder(ChatAction::class)
            ->onlyMethods([
                'send'
            ])
            ->getMock();

        $chat_action->method('send')
            ->willReturn($telegram_response);

        $sleep_time_setter = $this->createMock(SleepTimeSetter::class);
        $sleep_time_setter->method('sleepByStringLength')->willReturnCallback(function () {
            return;
        });

        $this->receiver = new Receiver($this->telegram_api, $chat_action);
    }

    public function testSendMessage()
    {
        // given
        $chat_id = 123;
        $message = 'test';
        $reply_to_message_id = 321;

        $this->telegram_api
            ->method('sendMessage')
            ->willReturn(new Message([
                'chat' => new Chat([
                    'id' => $chat_id
                ]),
                'text' => $message,
                'reply_to_message' => new Message([
                    'message_id' => $reply_to_message_id
                ])
            ]));

        // when
        $received_message = $this->receiver->sendMessage($chat_id, $message, $reply_to_message_id);

        // then
        $this->assertInstanceOf(Message::class, $received_message);
        // TODO rework test
        $this->assertEquals($chat_id, $received_message->getChat()->getId());
        $this->assertEquals($message, $received_message->getText());
        $this->assertEquals($reply_to_message_id, $received_message->getReplyToMessage()->getMessageId());
    }

    public function testSendSticker(): void
    {
        // given
        $chat_id = 123;
        $sticker_id = 'sticker_id';

        $this->telegram_api
            ->method('sendSticker')
            ->willReturn(new Message([
                'chat_id' => new Chat([
                    'id' => $chat_id
                ])
            ]));

        // when
        $received_message = $this->receiver->sendSticker($chat_id, $sticker_id);

        // then
        $this->assertInstanceOf(Message::class, $received_message);
    }
}
