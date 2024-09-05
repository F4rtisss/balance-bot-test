<?php

namespace App\Foundation;

use App\Foundation\Exceptions\AbstractClassNotFoundException;
use Closure;

class Container
{
    /**
     * @var array
     */
    private array $instances = [];

    /**
     * Зарегистрировать класс
     */
    public function bind(string $abstract, ?Closure $closure = null): Container
    {
        return $this->push($abstract, $closure);
    }

    /**
     * Singleton
     */
    public function singleton(string $abstract, ?Closure $closure = null): Container
    {
        return $this->push($abstract, $closure, true);
    }

    /**
     * Register
     */
    private function push(string $abstract, ?Closure $closure = null, bool $isSingleton = false): Container
    {
        $this->instances[$abstract] = [
            'abstract' => $abstract,
            'singleton' => $isSingleton,
            'closure' => $closure,
            'object' => null
        ];

        return $this;
    }

    /**
     * Получить объект из контейнера
     */
    public function make(string $abstract): mixed
    {
        if (! array_key_exists($abstract, $this->instances)) {
            try {
                return $this->createObject($abstract);
            } catch (\Throwable $exception) {
                throw new AbstractClassNotFoundException($abstract);
            }
        }

        return $this->resolve($this->instances[$abstract]);
    }

    /**
     * Реализовать объект
     */
    private function resolve(array $abstract): mixed
    {
        if ($abstract['singleton']) {
            if (! is_null($abstract['object'])) {
                return $abstract['object'];
            }

            return $this->instances[$abstract['abstract']]['object'] = $this->createObject($abstract['abstract'], $abstract['closure']);
        }

        return $this->createObject($abstract['abstract'], $abstract['closure']);
    }

    /**
     * Создание объекта
     */
    private function createObject(string $abstract, ?Closure $closure = null): mixed
    {
        if (is_null($closure)) {
            return new $abstract();
        }

        return $closure($this);
    }
}