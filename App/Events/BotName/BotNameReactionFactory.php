<?php

namespace App\Events\BotName;

class BotNameReactionFactory
{
    /**
     * @var \App\Events\BotName\BotNameReaction[]
     */
    private $reactions = [];

    /**
     * @param \App\Events\BotName\BotNameReaction[] $reactions
     */
    public function setReactions(array $reactions): void
    {
        $this->reactions = $reactions;
    }

    /**
     * @throws \Exception
     */
    public function getRandomReaction(): BotNameReaction
    {
        $this->checkReactions();

        $reactions_number = count($this->reactions);

        return $this->reactions[rand(0, --$reactions_number)];
    }

    /**
     * @throws \Exception
     */
    protected function checkReactions(): void
    {
        if (empty($this->reactions)) {
            throw new \Exception('Reactions are empty');
        }
    }
}