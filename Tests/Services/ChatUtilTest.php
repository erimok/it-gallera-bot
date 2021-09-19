<?php

namespace Services;

use App\Services\ChatUtil;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Message;

class ChatUtilTest extends TestCase
{
    /**
     * @var \stdClass
     */
    private $test_object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->test_object = new class {
            use ChatUtil;
        };
    }

    public function testGetChatFromMessage()
    {
        // given
        $chat_id = 123;
        $message = new Message([
            'chat' => new Chat([
                'id' => $chat_id
            ]),
            'message_id' => 123
        ]);

        // when
        $chat = $this->test_object->getChatFromMessage($message);

        // then
        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertEquals($chat_id, $chat->getId());
        $this->assertNull($this->test_object->getChatFromMessage(null));
    }
}
