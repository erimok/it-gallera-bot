<?php

namespace Commands;

use App\Commands\CommandValidation;
use PHPUnit\Framework\TestCase;

class CommandValidationTest extends TestCase
{
    /**
     * @var \App\Commands\CommandValidation
     */
    private $command_validation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command_validation = new CommandValidation();
    }

    /**
     * @depends testIsCorrectBotNameInCommand
     * @depends testIsGroupCommand
     */
    public function testIsThatBotCommand(): void
    {
        $bot_name = 'NameOfBot';
        $group_command = '/start@NameOfBot';
        $not_group_command  = '/start';
        $wrong_group_command  = '/test@NameOfBot';
        $wrong_command  = '/test';
        $command_name = 'start';

        $this->assertTrue($this->command_validation->isThatBotCommand($group_command, $command_name, $bot_name));
        $this->assertTrue($this->command_validation->isThatBotCommand($not_group_command, $command_name, $bot_name));
        $this->assertFalse($this->command_validation->isThatBotCommand($wrong_group_command, $command_name, $bot_name));
        $this->assertFalse($this->command_validation->isThatBotCommand($wrong_command, $command_name, $bot_name));
    }

    public function testIsGroupCommand(): void
    {
        $group_command = '/start@NameOfBot';
        $not_group_command = '/start';

        $this->assertTrue($this->command_validation->isGroupCommand($group_command));
        $this->assertFalse($this->command_validation->isGroupCommand($not_group_command));
    }

    /**
     * @depends testIsGroupCommand
     */
    public function testIsCorrectBotNameInCommand(): void
    {
        $bot_name = 'NameOfBot';
        $correct_bot_command = '/start@NameOfBot';
        $wrong_bot_command = '/start@WrongNameOfBot';

        $this->assertTrue($this->command_validation->isCorrectBotNameInCommand($correct_bot_command, $bot_name));
        $this->assertFalse($this->command_validation->isCorrectBotNameInCommand($wrong_bot_command, $bot_name));
    }
}
