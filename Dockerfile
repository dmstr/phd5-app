FROM dmstr/php-yii2:7.2-fpm-4.6-alpine-nginx
ARG BUILD_NO_INSTALL

RUN apk add --update $PHPIZE_DEPS \
 && pecl install mailparse \
 && docker-php-ext-enable mailparse \
 && apk del $PHPIZE_DEPS

# System files
COPY ./image-files /

# Application packages
WORKDIR /app
COPY composer.* /app/

# Composer installation (skipped on first build in dist-upgrade)
RUN if [ -z "$BUILD_NO_INSTALL" ]; then \
        composer install --no-dev --prefer-dist --optimize-autoloader && \
        composer clear-cache; \
    fi

# Application source-code
COPY yii /app/
COPY ./web /app/web/
COPY ./src /app/src/

# Tests source-code for integration tests in derived images
COPY ./tests /app/tests

# Permissions; run yii commands as webserver user
ENV PHP_USER_ID=82
RUN mkdir -p runtime web/assets web/bundles /mnt/storage && \
    chmod -R 775 runtime web/assets web/bundles /mnt/storage && \
    chmod -R ugo+r /root/.composer/vendor && \
    chmod u+x /usr/local/bin/unique-number.sh /usr/local/bin/export-env.sh && \
    chmod -R u+x /etc/periodic && \
    chown -R www-data:www-data runtime web/assets web/bundles /root/.composer/vendor /mnt/storage

# Build assets (skipped on first build in dist-upgrade)
RUN if [ -z "$BUILD_NO_INSTALL" ]; then \
        APP_NO_CACHE=1 APP_LANGUAGES=en yii asset/compress src/config/assets.php web/bundles/config.php; \
    fi

# Install crontab from application config
RUN crontab src/config/crontab

VOLUME /mnt/storage

# export container environment for cronjobs on container start
CMD /usr/local/bin/export-env.sh; forego start -r -f /root/Procfile