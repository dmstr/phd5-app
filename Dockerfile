FROM yiisoftware/yii2-php:8.4-fpm-nginx
ARG BUILD_NO_INSTALL

RUN apt-get update \
 && apt-get install -y $PHPIZE_DEPS \
        ssh \
        default-mysql-client \
        cron \
        procps # recommended for dmstr/yii2-resque-module \
 && apt-get remove -y $PHPIZE_DEPS \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN install-php-extensions \
        mailparse \
        ftp

ENV SUPERVISOR_START_CRON=true \
    SUPERVISOR_START_WORKER=true \
    SUPERVISOR_START_EXPORT_ENV=true \
    SUPERVISOR_WORKER_CMD_OPTS=""

# System files
COPY ./image-files /

# Application packages
WORKDIR /app
COPY src/composer.* /app/src/

# Composer installation (skipped on first build in dist-upgrade)
# create bc link if not exists
RUN if [ -z "$BUILD_NO_INSTALL" ]; then \
        composer -dsrc install --no-dev --prefer-dist --optimize-autoloader && \
        composer -dsrc clear-cache && \
        ln -s bower-asset /app/vendor/bower && \
        ln -s npm-asset /app/vendor/npm; \
    fi

# Application source-code
ENV PATH=/app/src/bin:$PATH
COPY ./web /app/web/
COPY ./src /app/src/
COPY ./config /app/config/
COPY ./migrations /app/migrations/

RUN test -f /app/yii || ln -s /app/src/bin/yii /app/yii

# Permissions
RUN mkdir -p runtime web/assets web/bundles /mnt/storage && \
    chmod -R 775 runtime web/assets web/bundles /mnt/storage && \
    chmod a+x /usr/local/bin/unique-number.sh /usr/local/bin/export-env.sh /usr/local/bin/nodepkg-linuxstatic && \
    chmod -R u+x /etc/periodic && \
    chown -R www-data:www-data runtime web/assets web/bundles /mnt/storage

VOLUME /app/runtime /app/web/assets /mnt/storage

# Build assets (skipped on first build in dist-upgrade)
RUN if [ -z "$BUILD_NO_INSTALL" ]; then \
        PHP_USER_ID=0 APP_NO_CACHE=1 APP_LANGUAGES=en APP_USER_FROM_EMAIL=build@Dockerfile APP_ADMIN_EMAIL=build@Dockerfile yii asset/compress config/assets.php web/bundles/config.php; \
    fi

# Install crontab from application config
RUN crontab config/crontab

# export container environment for cronjobs on container start
CMD supervisord -c /etc/supervisor/supervisord.conf

# Tests source-code for integration tests in derived images
COPY ./tests /app/tests

HEALTHCHECK --interval=30s --timeout=5s --start-period=1m \
  CMD curl -f http://localhost/static/status.php || exit 1
