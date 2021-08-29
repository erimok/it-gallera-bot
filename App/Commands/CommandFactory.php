<?php

namespace App\Commands;

final class CommandFactory
{
    /**
     * @var \App\Commands\Command[]
     */
    private $commands;

    /**
     * @param \App\Commands\Command[] $commands
     * @codeCoverageIgnore
     */
    public function setCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->commands[$command::NAME] = $command;
        }
    }

    /**
     * @throws \Exception
     */
    public function getCommand(string $command_name): Command
    {
        if (!key_exists($command_name, $this->commands)) {
            throw new \Exception('Command not found');
        }

        return $this->commands[$command_name];
    }

    /**
     * @return \App\Commands\Command[]
     * @codeCoverageIgnore
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}