<?php

namespace App\API;

final class UpdatesFetcher
{
    /**
     * @var \Telegram\Bot\Objects\Update[]
     */
    // todo add removing updates from array
    private $updates = [];

    /**
     * @var API
     */
    private $telegram_api;

    /**
     * @var int
     */
    private $last_processed_update_id = null;

    public function __construct(?\Telegram\Bot\Api $telegram_api = null)
    {
        $this->telegram_api = is_null($telegram_api) ? API::getInstance()->getTelegramApi() : $telegram_api;
    }

    public function getBotUpdatesFormApi(): void
    {
        $new_updates = $this->telegram_api->getUpdates([
            'offset' => $this->last_processed_update_id + 1
        ]);

        $this->updates = array_merge($this->updates, $new_updates);
    }

    public function getLastProcessedUpdateId(): ?int
    {
        return $this->last_processed_update_id;
    }

    public function setLastProcessedUpdateId(int $last_processed_update_id): void
    {
        $this->last_processed_update_id = $last_processed_update_id;
    }

    public function getUpdates(): array
    {
        return $this->updates;
    }

    public function removeUpdate(int $update_array_key): void
    {
        unset($this->updates[$update_array_key]);
    }
}