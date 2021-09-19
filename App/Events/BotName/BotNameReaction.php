<?php

namespace App\Events\BotName;

class BotNameReaction
{
    /**
     * @var string
     */
    private $reaction;

    /**
     * @var string|null
     */
    private $sticker_id;

    public function __construct(string $reaction, ?string $sticker_id = null)
    {
        $this->reaction = $reaction;
        $this->sticker_id = $sticker_id;
    }

    public function getReaction(): string
    {
        return $this->reaction;
    }

    public function getStickerId(): ?string
    {
        return $this->sticker_id;
    }

    public function isStickerSet(): bool
    {
        return $this->sticker_id !== null;
    }
}