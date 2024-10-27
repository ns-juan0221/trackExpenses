# PHP 8.0 FPMベース
FROM php:8.2-fpm

# 必要なPHP拡張機能をインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip

COPY ./php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Laravelプロジェクト用ディレクトリを作成
WORKDIR /var/www/html

# PHP-FPMをデフォルトコマンドに設定
CMD ["php-fpm"]
