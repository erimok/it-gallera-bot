<?php

namespace App\Handlers\Update;

use App\Commands\CommandFactory;
use App\Commands\CommandValidation;
use App\Services\UpdateUtil;
use Telegram\Bot\Objects\Update;

class CommandsHandler implements UpdateEventHandlerInterface
{
    use UpdateUtil;

    /**
     * @var \App\Commands\CommandFactory
     */
    private $command_factory;

    /**
     * @var \App\Commands\CommandValidation
     */
    private $command_validation;

    public function __construct(
        ?CommandFactory $command_factory = null,
        ?CommandValidation $command_validation = null
    )
    {
        $this->command_factory = is_null($command_factory) ? new CommandFactory() : $command_factory;
        $this->command_validation = is_null($command_validation) ? new CommandValidation() : $command_validation;
    }

    public function launch(Update $update): void
    {
        $text = $update->getMessage()->getText();
        $commands = $this->command_factory->getCommands();

        foreach ($commands as $command) {
            // todo bot_name rework
            if (
                $this->command_validation->isThatBotCommand($text, $command::NAME, 'ItGalleraBot')
//                $command->isThatCommand($text)
            ) {
                $command->launch($update);
                return;
            }
        }
    }

    public function isThatEvent(Update $update): bool
    {
        if (!$this->isUpdateHasText($update)) {
            return false;
        }

        return substr($update->getMessage()->getText(), 0, 1) === '/';
    }

    public function getCommandFactory(): CommandFactory
    {
        return $this->command_factory;
    }
}