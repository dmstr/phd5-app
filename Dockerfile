FROM registry-v2.hrzg.de/dmstr/php

WORKDIR /app

ARG GITHUB_API_TOKEN
ADD composer.lock composer.json /app/
RUN composer install --prefer-dist --optimize-autoloader

ADD yii /app/
ADD ./web /app/web/
ADD ./src /app/src/
RUN cp src/app.env-dist src/app.env

RUN mkdir -p runtime web/assets && \
    chmod -R 775 runtime web/assets && \
    chown -R 1000:33 runtime web/assets
