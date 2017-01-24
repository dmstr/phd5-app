FROM dmstr/php-yii2:7.0-fpm-1.9-beta2-alpine-nginx

WORKDIR /app

ARG GITHUB_API_TOKEN
COPY composer.* /app/
RUN composer install --prefer-dist --optimize-autoloader

COPY yii /app/
COPY ./web /app/web/
COPY ./src /app/src/
RUN cp src/app.env-dist src/app.env

RUN mkdir -p runtime web/assets web/bundles && \
    APP_NAME=build APP_LANGUAGES=en yii asset/compress src/config/assets.php web/bundles/config.php && \
    chmod -R 775 runtime web/assets && \
    chown -R 1000:82 runtime web/assets /root/.composer/vendor

RUN crontab src/config/crontab