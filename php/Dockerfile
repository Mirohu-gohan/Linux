FROM php:7.3-apache

# 1. 設定ファイルの配置
COPY ./php.ini /usr/local/etc/php/

# 2. 古いDebian用の接続先修正 ＆ 必要なツールを一括インストール
RUN sed -i '/debian-security/d' /etc/apt/sources.list \
    && sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && apt-get update -o Acquire::Check-Valid-Until=false \
    && apt-get install -y --no-install-recommends \
       libfreetype6-dev \
       libjpeg62-turbo-dev \
       libpng-dev \
       libmemcached-dev \
       zlib1g-dev \
       vim \
       default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# 3. PHP用の拡張機能をインストール（※ mysql ではなく mysqli を使用）
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring gd iconv

# 4. Memcached（高速キャッシュ）の有効化
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# 5. Apache設定ファイルのコピー
COPY ./php_apache2.conf /etc/apache2/mods-enabled/