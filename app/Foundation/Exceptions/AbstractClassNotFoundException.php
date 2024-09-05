<?php

namespace App\Foundation\Exceptions;

class AbstractClassNotFoundException extends \Exception
{
    /**
     * AbstractClassNotFoundException constructor
     */
    public function __construct(string $abstractClass)
    {
        parent::__construct("Не смогли реализовать класс: $abstractClass");
    }
}