<?php

namespace API;

use App\API\API;
use PHPUnit\Framework\TestCase;

final class APITest extends TestCase
{
    public function testGetInstanceWithoutEnvToken()
    {
        $this->expectException(\Exception::class);

        API::getInstance();
    }

    /**
     * @depends testGetInstanceWithoutEnvToken
     */
    public function testGetInstance()
    {
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();
        $dotenv->load(dirname(__FILE__, 3) . '/.env');

        $this->assertInstanceOf(API::class, API::getInstance());
    }

    /**
     * @depends testGetInstanceWithoutEnvToken
     */
    public function testGetTelegramApi()
    {
        $telegram_api = API::getInstance('test_bot_token')->getTelegramApi();

        $this->assertInstanceOf(\Telegram\Bot\Api::class, $telegram_api);
        $this->assertEquals($_ENV['TELEGRAM_BOT_TOKEN'], $telegram_api->getAccessToken());
    }

}
