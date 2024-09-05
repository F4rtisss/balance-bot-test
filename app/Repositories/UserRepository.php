<?php

namespace App\Repositories;

use App\Foundation\Repositories\DBRepository;

class UserRepository extends DBRepository
{
    /**
     * Получить пользователя по ChatId
     */
    public function getUserByChatId(int $chatId): mixed
    {
        return $this->first("SELECT * FROM users WHERE telegram_id = ?", [$chatId]);
    }

    /**
     * Создать пользователя
     */
    public function create(int $chatId): void
    {
        $this->insert("INSERT INTO users (telegram_id) VALUES (?)", [$chatId]);
    }

    /**
     * Обновить баланс пользователя
     */
    public function updateBalanceByUserId(int $userId, float $balance): void
    {
        $this->update("UPDATE users SET balance = ? WHERE id = ?", [$balance, $userId]);
    }

    /**
     * Обновить баланс пользователя использя telegram chat id
     */
    public function updateBalanceByChatId(int $chatId, float $balance): void
    {
        $this->update("UPDATE users SET balance = ? WHERE telegram_id = ?", [$balance, $chatId]);
    }
}