FROM dmstr/php-yii2:7.0-fpm-1.6-rc3-nginx

WORKDIR /app

ARG GITHUB_API_TOKEN
COPY composer.lock composer.json /app/
RUN composer install --prefer-dist --optimize-autoloader

COPY yii /app/
COPY ./web /app/web/
COPY ./src /app/src/
RUN cp src/app.env-dist src/app.env

RUN mkdir -p runtime web/assets web/bundles && \
    yii asset/compress src/config/assets.php web/bundles/config.php && \
    chmod -R 775 runtime web/assets && \
    chown -R 1000:33 runtime web/assets
