FROM php:8.2-cli

# 必要なツールをインストール
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    build-essential \
    vim \
    && apt-get clean

# Node.js v22.11.0をインストール（ARM対応バイナリ）
RUN curl -fsSL https://nodejs.org/dist/v22.11.0/node-v22.11.0-linux-arm64.tar.xz -o node.tar.xz && \
    tar -xJf node.tar.xz -C /usr/local --strip-components=1 && \
    rm node.tar.xz

# Composerをインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
