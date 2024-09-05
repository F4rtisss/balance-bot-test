<?php

namespace App\Foundation\Repositories;

use App\Foundation\Application;
use App\Services\DBService;

abstract class DBRepository
{
    /**
     * @var DBService
     */
    private DBService $DBService;

    /**
     * DBRepository constructor
     */
    public function __construct()
    {
        $this->DBService = Application::create()->make(DBService::class);
    }

    /**
     * Получить одну запись
     */
    public function first(string $sql, array $params = null): mixed
    {
        $state = $this->DBService->getConnection()->prepare($sql);
        $state->execute($params);

        return $state->fetch();
    }

    /**
     * Получить все записи
     */
    public function get(string $sql, array $params = null): array|false
    {
        $state = $this->DBService->getConnection()->prepare($sql);
        $state->execute($params);

        return $state->fetchAll();
    }

    /**
     * Вставка
     */
    public function insert(string $sql, array $params = []): void
    {
        $state = $this->DBService->getConnection()->prepare($sql);
        $state->execute($params);
    }

    /**
     * Обновить
     */
    public function update(string $sql, array $params = []): void
    {
        $state = $this->DBService->getConnection()->prepare($sql);
        $state->execute($params);
    }
}