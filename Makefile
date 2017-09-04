.PHONY: all dev init bash exec upgrade update assets latest

include ./Makefile.base

all:    ##@development shorthand for 'build init up setup open'
all: init build dev up setup open
all:
	#
	# make all
	# Done.

dev:    ##@development install composer package (enable host-volume in docker-compose config)
dev:
	#
	# Running composer installation in development environment
	# This may take a while on your first install...
	#
	$(DOCKER_COMPOSE) run --rm php composer install

init:   ##@development initialize development environment
	#
	# Initializing development environment
	#
	cp -n .env-dist .env &2>/dev/null
	cp -n tests/.env-dist tests/.env &2>/dev/null
	cp -n src/app.env-dist src/app.env &2>/dev/null
	mkdir -p web/assets runtime

bash:	 ##@development run application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) run --rm php bash

exec:	 ##@development execute command (c='yii help') in running container
	#
	# Running command
	# Note: Make sure the application container is running
	#
	$(DOCKER_COMPOSE) exec php $(c)

upgrade: ##@development update application package, pull, rebuild
	#
	# Running package upgrade in container
	# Note: If you have performance with this operation issues, please check the documentation under http://phd.dmstr.io/docs
	#
	$(DOCKER_COMPOSE) run --rm php composer update -v

dist-upgrade: build update
dist-upgrade: ##@development update application package, pull, rebuild
	$(MAKE) build
	$(MAKE) upgrade
	$(MAKE) build

assets:	 ##@development open application development bash
	#
	# Building asset bundles
	#
	$(DOCKER_COMPOSE) run --rm -e APP_ASSET_USE_BUNDLED=0 php yii asset/compress src/config/assets.php web/bundles/config.php

latest: ##@development push to latest (release) branch
	#
	# Pushing to latest branch
	#
	git push origin master:latest
