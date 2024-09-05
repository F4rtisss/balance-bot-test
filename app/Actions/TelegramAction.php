<?php

namespace App\Actions;

use App\Foundation\Application;
use App\Foundation\Console;
use App\Repositories\UserRepository;
use App\Services\BotService;
use TelegramBot\Api\Types\Update;

class TelegramAction
{
    /**
     * @var Console|mixed
     */
    private Console $console;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var BotService
     */
    private BotService $botService;

    /**
     * TelegramAction constructor
     */
    public function __construct()
    {
        $app = Application::create();

        $this->console = $app->make(Console::class);
        $this->userRepository = $app->make(UserRepository::class);
        $this->botService = $app->make(BotService::class);
    }

    /**
     * Запустить действие
     */
    public function run()
    {
        $offset = 0;

        while (true) {
            $this->console->echo('Получаем новые сообщения...');
            /** @var Update $update */
            foreach ($this->botService->getUpdates($offset) as $update) {
                $offset = $update->getUpdateId() + 1;
                $message = $update->getMessage();
                $chatId = $message->getChat()->getId();
                $text = $message->getText();

                $this->console->echo("Пришло сообщение от: $chatId - обрабатываем");
                $this->processing($chatId, $text);
            }

            sleep(1);
        }
    }

    /**
     * Обработка сообщения
     */
    private function processing(int $chatId, string $text): void
    {
        // Получаем пользователя
        $user = $this->userRepository->getUserByChatId($chatId);

        // Если пользователя нет, тогда создаём его и отправляем привественное сообщение
        if (! $user) {
            $this->userRepository->create($chatId);
            $this->botService->sendMessage($chatId, "Ваш аккаунт был создан. Баланс: $0.00");

            return;
        }

        if (! $this->isNumber($text)) {
            $this->botService->sendMessage($chatId, "Пожалуйста, введите число для пополнения/списания средств.");

            return;
        }

        $balance = $user['balance'] + $this->parseAmount($text);
        if ($balance < 0) {
            $this->botService->sendMessage($chatId, "Недостаточно средств на счёте. Баланс: $" . $this->getBalanceFormatted($user['balance']));

            return;
        }

        $this->userRepository->updateBalanceByUserId($user['id'], $balance);
        $this->botService->sendMessage($chatId, "Баланс обновлён: $" . $this->getBalanceFormatted($balance));
    }

    /**
     * @param float $balance
     * @return string
     */
    private function getBalanceFormatted(float $balance): string
    {
        return number_format($balance, 2);
    }

    /**
     * @param $text
     * @return bool
     */
    private function isNumber($text): bool
    {
        return is_numeric(str_replace([','], '.', $text));
    }

    /**
     * @param $text
     * @return float
     */
    private function parseAmount($text): float
    {
        return floatval(str_replace([','], '.', $text));
    }
}