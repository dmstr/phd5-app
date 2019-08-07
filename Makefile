.PHONY: all dev init bash exec upgrade update assets latest


PHP_SERVICE     ?= php
TESTER_SERVICE  ?= tester
BROWSER_SERVICE ?= chrome
COMPOSE_FILE_QA ?= ../docker-compose.yml:./docker-compose.test.yml:./docker-compose.qa.yml


include ./Makefile.base

all:    ##@development shorthand for 'build init up setup open'
all: dev-init build install up setup open
all:
	#
	# make all
	# Done.
PHP_SERVICE     ?= php
TESTER_SERVICE  ?= tester
BROWSER_SERVICE ?= chrome
COMPOSE_FILE_QA ?= ../docker-compose.yml:./docker-compose.test.yml:./docker-compose.qa.yml


dev-init:    ##@development install composer package (enable host-volume in docker-compose config)
dev-init:
	#
	# Running composer installation in development environment
	# This may take a while on your first install...
	#
	cp -n .env-dist .env &2>/dev/null
	mkdir -p web/assets runtime

install:
	$(DOCKER_COMPOSE) run --rm php composer install

bash:	 ##@development run application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) run --rm php bash

test-bash:	 ##@development run application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) run --rm test-php bash

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

dist-upgrade: ##@development update application package, pull, rebuild
	$(DOCKER_COMPOSE) build --pull --build-arg BUILD_NO_INSTALL=1
	$(MAKE) upgrade
	$(MAKE) build

assets:	 ##@development open application development bash
	#
	# Building asset bundles
	#
	$(DOCKER_COMPOSE) run --rm -e APP_ASSET_USE_BUNDLED=0 php yii asset/compress src/config/assets.php web/bundles/config.php

latest: ##@development push to latest branch
	#
	# Pushing to latest branch
	#
	git push origin master:latest

release: ##@development push to release branch
	#
	# Pushing to latest branch
	#
	git push origin master:release

open: ##@base open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port php 80 | sed 's/[0-9.]*://') &>/dev/null

test-browser: ##@base open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port test-php 80 | sed 's/[0-9.]*://') &>/dev/null

test-selenium: ##@test open application database service in browser
	$(OPEN_CMD) vnc://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(BROWSER_SERVICE) 5900 | sed 's/[0-9.]*://') &>/dev/null

open-report: ##@test open HTML reports
	$(OPEN_CMD) _log/codeception/report.html &>/dev/null

open-coverage: ##@test open HTML reports
	$(OPEN_CMD) _log/coverage/index.html &>/dev/null

open-c3:
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port web 80 | sed 's/[0-9.]*://')/c3/report/clear &>/dev/null
