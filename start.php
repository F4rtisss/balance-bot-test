<?php


// Подключаем автозагрузчик
require './vendor/autoload.php';

// Создаём приложение
$app = \App\Foundation\Application::create(__DIR__);

// Запускаем telegram-бота
$app->make(\App\Actions\TelegramAction::class)->run();
