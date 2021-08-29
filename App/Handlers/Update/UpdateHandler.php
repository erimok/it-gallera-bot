<?php

namespace App\Handlers\Update;

use App\API\ChatsList;
use App\API\UpdatesFetcher;
use Telegram\Bot\Objects\Update;

final class UpdateHandler implements \App\Handlers\HandlerInterface
{
    /**
     * @var \App\API\UpdatesFetcher
     */
    private $update_fetcher;

    /**
     * @var \App\Handlers\Update\UpdateEventHandlerInterface[]
     */
    private $update_events_handlers;

    public function __construct(
        ?UpdatesFetcher $update_fetcher = null
    )
    {
        $this->update_fetcher = is_null($update_fetcher) ? new UpdatesFetcher() : $update_fetcher;
    }

    /**
     * @throws \Exception
     */
    public function launchHandler(): void
    {
        $this->update_fetcher->getBotUpdatesFormApi();

        print_r(ChatsList::getInstance()->getChats());

        foreach ($this->update_fetcher->getUpdates() as $id => $update) {
            $this->processUpdate($update);

            ChatsList::getInstance()->addChatToList($update->getMessage()->getChat());

            $this->update_fetcher->setLastProcessedUpdateId($update->getUpdateId());
            $this->update_fetcher->removeUpdate($id);
        }
    }

    protected function processUpdate(Update $update): void
    {
        foreach ($this->update_events_handlers as $handler) {
            if ($handler->isThatEvent($update)) {
                $handler->launch($update);
            }
        }
    }

    /**
     * @return \App\API\UpdatesFetcher
     */
    public function getUpdateFetcher(): UpdatesFetcher
    {
        return $this->update_fetcher;
    }

    /**
     * @param \App\Handlers\Update\UpdateEventHandlerInterface[] $update_events_handlers
     */
    public function setUpdateEventsHandlers(array $update_events_handlers): void
    {
        $this->update_events_handlers = $update_events_handlers;
    }
}