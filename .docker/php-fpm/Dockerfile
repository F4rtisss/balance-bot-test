FROM php:8.3-fpm

WORKDIR /var/www

# Используемый образ для сборки
# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y \
    g++ \
    libpng-dev \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libz-dev \
    zip \
    wget \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    zlib1g-dev \
    && pecl install redis \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install opcache pdo pdo_mysql zip gd pcntl intl \
    && docker-php-ext-enable redis gd opcache pcntl pdo_mysql zip intl

# Скачиваем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Создаём пользователя в контейнере
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Копируем файлы в контейнер со всеим правами
COPY --chown=www:www . .

# Переключаемся на созданного пользователя
USER www

# Запускаем php
CMD ["php-fpm"]
