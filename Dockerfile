FROM dmstr/php-yii2:7.1-fpm-2.0-beta1-alpine-nginx-xdebug

WORKDIR /app

# Application packages
ARG GITHUB_API_TOKEN
COPY composer.* /app/
RUN composer install --prefer-dist --optimize-autoloader

# Application source-code
COPY yii /app/
COPY ./web /app/web/
COPY ./src /app/src/
RUN cp src/app.env-dist src/app.env

# Permissions
RUN mkdir -p runtime web/assets web/bundles && \
    APP_NAME=build APP_LANGUAGES=en yii asset/compress src/config/assets.php web/bundles/config.php && \
    chmod -R 775 runtime web/assets && \
    chmod -R ugo+r /root/.composer/vendor && \
    chown -R 1000:82 runtime web/assets /root/.composer/vendor

# Install crontab from application config (
RUN crontab src/config/crontab