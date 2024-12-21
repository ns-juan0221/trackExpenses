# PHP 8.0 FPMベース
FROM php:8.2-fpm

# Laravelプロジェクト用ディレクトリを作成
WORKDIR /var/www/html

# 必要なPHP拡張機能をインストール
RUN addgroup --system nginx && adduser --system --ingroup nginx nginx && \
    mkdir /var/run/php-fpm && \
    apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install xdebug \
    docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

COPY ./php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./php.ini /usr/local/etc/php/php.ini

# PHP-FPMをデフォルトコマンドに設定
CMD ["php-fpm"]
