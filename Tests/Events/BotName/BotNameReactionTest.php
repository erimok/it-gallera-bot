<?php

namespace Events\BotName;

use App\Events\BotName\BotNameReaction;
use PHPUnit\Framework\TestCase;

class BotNameReactionTest extends TestCase
{
    /**
     * @var BotNameReaction
     */
    private $reaction_within_sticker;

    /**
     * @var BotNameReaction
     */
    private $reaction_without_sticker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reaction_within_sticker = new BotNameReaction('test message', 123456);
        $this->reaction_without_sticker = new BotNameReaction('test');
    }

    public function testIsStickerSet()
    {
        $this->assertTrue($this->reaction_within_sticker->isStickerSet());
        $this->assertFalse($this->reaction_without_sticker->isStickerSet());
    }

    public function testGetReaction()
    {
        $this->assertEquals('test message', $this->reaction_within_sticker->getReaction());
    }

    public function testGetStickerId()
    {
        $this->assertEquals(123456, $this->reaction_within_sticker->getStickerId());
    }
}
