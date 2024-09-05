<?php

namespace App\Services;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Message;

class BotService
{
    /**
     * API Telegram Bot
     */
    private BotApi $botApi;

    /**
     * BotService constructor
     *
     * @throws \Exception
     */
    public function __construct(private string $token)
    {
        $this->botApi = new BotApi($this->token);
    }

    /**
     * Получить новые сообщения
     */
    public function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 0): array
    {
        return $this->botApi->getUpdates($offset, $limit, $timeout);
    }

    /**
     * Отправить сообщение
     *
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendMessage(int $chatId, string $message): Message
    {
        return $this->botApi->sendMessage($chatId, $message);
    }
}