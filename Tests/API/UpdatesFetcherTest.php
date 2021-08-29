<?php

namespace API;

use App\API\UpdatesFetcher;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdatesFetcherTest extends TestCase
{
    /**
     * @var UpdatesFetcher
     */
    private $update_fetcher;

    protected function setUp(): void
    {
        parent::setUp();

        $telegram_api = $this->createMock(Api::class);
        $telegram_api->method('getUpdates')
            ->willReturn([
                new Update([
                    'update_id' => 123
                ])
            ]);

        $this->update_fetcher = new UpdatesFetcher($telegram_api);
    }

    /**
     * @depends testGetBotUpdatesFormApi
     * todo check logic
     */
    public function testRemoveUpdate()
    {
        $this->assertEmpty($this->update_fetcher->getUpdates());
    }

    // todo check
    public function testGetBotUpdatesFormApi()
    {
        $this->update_fetcher->getBotUpdatesFormApi();

        $updates = $this->update_fetcher->getUpdates();

        $this->assertIsArray($updates);
        $this->assertInstanceOf(Update::class, $updates[0]);
    }
}
