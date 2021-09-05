<?php

namespace Services;

use App\Services\UpdateUtil;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class UpdateUtilTest extends TestCase
{
    /**
     * @var \stdClass
     */
    private $test_object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->test_object = new class {
            use UpdateUtil;
        };
    }

    public function testIsUpdateHasText()
    {
        // given
        $correct_update = $this->getUpdate(new Message([
            'message_id' => 123,
            'text' => 'test text'
        ]));
        $update_with_empty_message_text = $this->getUpdate(new Message([
            'message_id' => 123,
            'text' => ''
        ]));

        // when
        $correct_validation = $this->test_object->isUpdateHasText($correct_update);
        $incorrect_validation = $this->test_object->isUpdateHasText(new Update([]));
        $validation_without_text = $this->test_object->isUpdateHasText($update_with_empty_message_text);

        // then
        $this->assertTrue($correct_validation);
        $this->assertFalse($incorrect_validation);
        $this->assertFalse($validation_without_text);
    }

    protected function getUpdate(Message $message): Update
    {
        return new Update([
            'message' => $message
        ]);
    }
}
