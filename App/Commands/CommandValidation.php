<?php

namespace App\Commands;

class CommandValidation
{
    /**
     * @var int|null
     */
    private $at_position = null;

    public function isThatBotCommand(string $text, string $command, string $bot_name): bool
    {
        $found_command = $text;

        if ($this->isGroupCommand($text) && !$this->isCorrectBotNameInCommand($text, $bot_name)) {
            return false;
        }

        if ($this->at_position !== null) {
            $found_command = substr($text, 0, $this->at_position);
        }

        return $found_command === '/' . $command;
    }

    public function isGroupCommand(string $text): bool
    {
        $at_position = strpos($text, '@');

        if ($at_position === false) {
            $this->at_position = null;

            return false;
        }

        $this->at_position = $at_position;

        return true;
    }

    public function isCorrectBotNameInCommand(string $text, string $bot_name): bool
    {
        if ($this->at_position === null) {
            $this->at_position = strpos($text, '@');
        }

        $text_bot_name = substr($text, $this->at_position + 1);

        return $text_bot_name === $bot_name;
    }
}