<?php

namespace App\API;

final class API
{
    /**
     * @var \App\API\API
     */
    private static $api;

    /**
     * @var \Telegram\Bot\Api
     */
    private $telegram_api;

    /**
     * @throws \Exception
     */
    protected function __construct(?string $api_token = null)
    {
        $this->validateToken($api_token);
        $this->setTelegramApi($api_token);
    }

    /**
     * @throws \Exception
     */
    protected function validateToken(?string $api_token): void
    {
        if (empty($api_token)) {
            throw new \Exception('API token is not set');
        }
    }

    /**
     * @throws \Exception
     * todo additional test case
     */
    public static function getInstance(string $bot_token = null): self
    {
        if (!isset(self::$api)) {
            if (!empty($bot_token)) {
                self::$api = new API($bot_token);
            } else {
                self::$api = new API($_ENV['TELEGRAM_BOT_TOKEN']);
            }
        }

        return self::$api;
    }

    public function getTelegramApi(): \Telegram\Bot\Api
    {
        return $this->telegram_api;
    }

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function setTelegramApi(string $api_token): void
    {
        $this->telegram_api = new \Telegram\Bot\Api($api_token);
    }
}