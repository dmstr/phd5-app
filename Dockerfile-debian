FROM dmstr/php-yii2:7.3-fpm-6.0-rc1-nginx
ARG BUILD_NO_INSTALL

RUN apt-get update \
 && apt-get install -y $PHPIZE_DEPS \
        procps # recommended for dmstr/yii2-resque-module \
 && pecl install mailparse \
 && docker-php-ext-enable mailparse \
 && apt-get remove -y $PHPIZE_DEPS


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

# Permissions
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
CMD /usr/local/bin/export-env.sh; supervisord -c /etc/supervisor/supervisord.conf