<?php

namespace App\Handlers\Update;

use App\API\UpdatesFetcher;
use App\Commands\CommandFactory;
use Telegram\Bot\Objects\Update;

final class UpdateHandler implements \App\Handlers\HandlerInterface
{
    /**
     * @var \App\API\UpdatesFetcher
     */
    private $update_fetcher;

    /**
     * @var \App\Commands\CommandFactory
     */
    private $command_factory;

    public function __construct(
        ?UpdatesFetcher $update_fetcher = null,
        ?CommandFactory $command_factory = null
    )
    {
        $this->update_fetcher = is_null($update_fetcher) ? new UpdatesFetcher() : $update_fetcher;
        $this->command_factory = is_null($command_factory) ? new CommandFactory() : $command_factory;
    }

    public function launchHandler(): void
    {
        $this->update_fetcher->getBotUpdatesFormApi();

        foreach ($this->update_fetcher->getUpdates() as $id => $update) {
            $this->processUpdate($update);
            $this->update_fetcher->setLastProcessedUpdateId($update->getUpdateId());
            $this->update_fetcher->removeUpdate($id);
        }
    }

    protected function processUpdate(Update $update): void
    {
        foreach ($this->command_factory->getCommands() as $command) {
            if ($command->isThatCommand($update->getMessage()->getText())) {
                $command->launch($update);
            }
        }
    }

    /**
     * @return \App\Commands\CommandFactory
     */
    public function getCommandFactory(): CommandFactory
    {
        return $this->command_factory;
    }

    /**
     * @return \App\API\UpdatesFetcher
     */
    public function getUpdateFetcher(): UpdatesFetcher
    {
        return $this->update_fetcher;
    }
}