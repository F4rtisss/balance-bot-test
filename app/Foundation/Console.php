<?php

namespace App\Foundation;

use Carbon\Carbon;

class Console
{
    /**
     * Вывести сообщение
     */
    public function echo(string $message): void
    {
        echo sprintf("[%s] %s%s", Carbon::now()->toString(), $message, PHP_EOL);
    }
}