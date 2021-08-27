<?php

namespace App\Commands;

final class CommandFactory
{
    /**
     * @var \App\Commands\CommandInterface[]
     */
    private $commands;

    /**
     * @param \App\Commands\CommandInterface[] $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    /**
     * @throws \Exception
     */
    public function getCommand(string $command_name): CommandInterface
    {
        if (!key_exists($command_name, $this->commands)) {
            throw new \Exception('Command not found');
        }

        return $this->commands[$command_name];
    }

    /**
     * @return \App\Commands\CommandInterface[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}