<?php

namespace App\Handlers\Update;

use App\Commands\CommandFactory;
use Telegram\Bot\Objects\Update;

class CommandsHandler implements UpdateEventHandlerInterface
{
    /**
     * @var \App\Commands\CommandFactory
     */
    private $command_factory;

    public function __construct(?CommandFactory $command_factory = null)
    {
        $this->command_factory = is_null($command_factory) ? new CommandFactory() : $command_factory;
    }

    public function launch(Update $update): void
    {
        $text = $update->getMessage()->getText();
        $commands = $this->command_factory->getCommands();

        foreach ($commands as $command) {
            if ($command->isThatCommand($text)) {
                $command->launch($update);
                return;
            }
        }
    }

    public function isThatEvent(Update $update): bool
    {
        return substr($update->getMessage()->getText(), 0, 1) === '/';
    }

    public function getCommandFactory(): CommandFactory
    {
        return $this->command_factory;
    }
}