<?php

namespace App\Services;

use PDO;

class DBService
{
    /**
     * Реализуем singleton
     */
    private static ?DBService $instance = null;

    /**
     * Подключение к БД
     */
    private PDO $pdo;

    /**
     * DBService constructor
     */
    private function __construct($dbConfig)
    {
        $dsn = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['dbname'] . ";charset=utf8";

        try {
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true
            ]);
        } catch (\PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    /**
     * @param $dbConfig
     * @return DBService
     */
    public static function getInstance($dbConfig): DBService
    {
        if (self::$instance === null) {
            self::$instance = new self($dbConfig);
        }

        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}