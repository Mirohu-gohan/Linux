FROM mysql:8.0.36-debian

# 日本語ロケールとタイムゾーンの設定
RUN apt-get update && apt-get install -y --no-install-recommends locales \
    && sed -i 's/# ja_JP.UTF-8 UTF-8/ja_JP.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen \
    && rm -rf /var/lib/apt/lists/*

ENV LANG=ja_JP.UTF-8 \
    LC_ALL=ja_JP.UTF-8 \
    TZ=Asia/Tokyo

# 設定ファイルと初期化SQLのコピー
COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./initialize.sql /docker-entrypoint-initdb.d/