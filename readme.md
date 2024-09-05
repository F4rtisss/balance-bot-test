# Telegram Bot with PHP and MySQL

Этот проект представляет собой простого Telegram-бота, написанного на PHP, который использует MySQL в качестве базы данных. Бот позволяет пользователям управлять своим балансом с помощью команд, отправленных в чат.

## Необходимое ПО

Для запуска проекта вам потребуется:

- **Docker**: Платформа для создания и управления контейнерами.

## Действия для запуска проекта

Следуйте этим шагам, чтобы запустить проект:

1. **Запустите контейнеры с помощью Docker Compose:**

   В корневой директории проекта выполните команду:
   ```bash
   docker-compose up -d && docker exec -it app bash

2. **Установите зависимости composer:**
    ```bash
   composer install
   
3. **Создайте все необходимые таблицы с помощью SQL:**
    Когда Вы запустите docker-compose - у вас будет доступен phpMyAdmin: http://localhost:8080
    Откройте таблицу root и выполните запросы из файла: database/create_database.sql

4. **Создайте копию из .env.example и пропишите необходимые доступы TG_TOKEN**
    ```bash
   cp .env.example .env

5. **Запуск скрипта бота:**
    ```bash
   php start.php
