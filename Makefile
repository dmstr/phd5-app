.PHONY: all dev init bash exec upgrade update assets latest default build up clean open open-db setup help

PHP_SERVICE     ?= php
TESTER_SERVICE  ?= test-php
BROWSER_SERVICE ?= chrome
COMPOSE_FILE_QA ?= ../docker-compose.yml:./docker-compose.test.yml:./docker-compose.qa.yml


# Define the docker-compose binary via ENV variable
DOCKER_COMPOSE  ?= docker-compose
# Default for Linux & Docker for Mac, set ENV variable when running i.e. docker-machine under macOS
DOCKER_HOST     ?= localhost

UNAME_S := $(shell uname -s)
ifeq ($(UNAME_S), Darwin)
	OPEN_CMD        ?= open
else
	OPEN_CMD        ?= xdg-open
endif

ifdef DOCKER_HOST
	DOCKER_HOST_IP  ?= $(shell echo $(DOCKER_HOST) | sed 's/tcp:\/\///' | sed 's/:[0-9.]*//')
else
	DOCKER_HOST_IP  ?= 127.0.0.1
endif


# Targets
# -------

default: help

all:    ##@base shorthand for 'build init up setup open'
all: dev-init build install up setup open
all:
	#
	# make all
	# Done.


build: ##@base build images in stack
	#
	# Building images from docker-compose definitions
	#
	$(DOCKER_COMPOSE) build --pull

up: ##@base start stack
	#
	# Starting application stack
	#
	$(DOCKER_COMPOSE) up -d

clean: ##@base remove all containers in stack
	#
	# Cleaning Docker environment
	#
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) rm -fv
	$(DOCKER_COMPOSE) down --remove-orphans

open-db: ##@base open application database service in browser
	$(OPEN_CMD) mysql://root:secret@$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port db 3306 | sed 's/[0-9.]*://') &>/dev/null

logs: ##@base show logs
	#
	# Running application setup command (database, user)
	#
	$(DOCKER_COMPOSE) logs -f --tail 100 | cat -v


version: ##@base write current version string from git
	$(shell echo $(shell git describe --long --tags --dirty --always) > ./src/version)
	@echo $(shell cat ./src/version)

install:
	$(DOCKER_COMPOSE) run --rm php composer install

bash:	 ##@development run application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) run --rm php bash


bash-xdebug: ##@development open application development bash with xdebug enabled
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 $(TESTER_SERVICE) bash


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

dev-assets:	 ##@development open application development bash
	#
	# Building asset bundles
	#
	$(DOCKER_COMPOSE) run --rm -e APP_ASSET_USE_BUNDLED=0 php yii asset/compress src/config/assets.php web/bundles/config.php


dev-init:    ##@development install composer package (enable host-volume in docker-compose config)
dev-init:
	#
	# Running composer installation in development environment
	# This may take a while on your first install...
	#
	cp -n .env-dist .env &2>/dev/null
	mkdir -p web/assets runtime

dev-setup: ##@development run application setup
	#
	# Running application setup command (database, user)
	#
	$(DOCKER_COMPOSE) run --rm php yii app/setup

dev-browser: ##@development open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port php 80 | sed 's/[0-9.]*://') &>/dev/null


up-xdebug: ##@development open application development bash with xdebug enabled
	PHP_ENABLE_XDEBUG=1 $(DOCKER_COMPOSE) up -d


test: build install up
test: ##@test run tests
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept clean
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept run --env $(BROWSER_SERVICE) -x optional --steps --html --xml= --tap --json
	$(DOCKER_COMPOSE) logs $(PHP_SERVICE) > _log/docker.log

test-coverage: ##@test run tests with code coverage
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept clean
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 $(TESTER_SERVICE) codecept run --env $(BROWSER_SERVICE) -x optional --coverage-html --coverage-xml --html --xml

test-init: ##@test initialize test-environment
	cp -n .env-dist .env &2>/dev/null
	mkdir -p _log/codeception && chmod 777 _log/codeception
	mkdir -p _log/lint && chmod 777 _log/lint

test-bash:	 ##@test run application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) run --rm test-php bash

test-browser: ##@test open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port test-php 80 | sed 's/[0-9.]*://') &>/dev/null

test-selenium: ##@test open application database service in browser
	$(OPEN_CMD) vnc://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(BROWSER_SERVICE) 5900 | sed 's/[0-9.]*://') &>/dev/null

test-report: ##@test open HTML reports
	$(OPEN_CMD) _log/codeception/report.html &>/dev/null

test-report-coverage: ##@test open HTML reports
	$(OPEN_CMD) _log/coverage/index.html &>/dev/null



lint-source:	 ##@development run source-code linting
	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Liniting source-code with cs-fixer, phpmetrics & phpmd
	#
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) php-cs-fixer fix --format=txt -v --dry-run ../src
	docker run --rm -v "${PWD}/..:/app" --workdir=/app herloct/phpmetrics --report-html=tests/_log/lint/metrics --excluded-dirs=migrations src/
	docker run --rm -v "${PWD}/..:/project" jolicode/phaudit phpmd src html tests/phpmd/rulesets.xml --exclude src/migrations > _log/lint/mess.html
	exit ${ERROR}

lint-composer: ##@development run composer linting
	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Liniting composer configuration
	#
	cd ..; \
	$(DOCKER_COMPOSE) run --rm $(PHP_SERVICE) composer --no-ansi validate || ERROR=1; \
	$(DOCKER_COMPOSE) run --rm $(PHP_SERVICE) composer --no-ansi show | tee tests/_log/composer-packages-$(shell cat ../src/version).txt || ERROR=1; \
	$(DOCKER_COMPOSE) run --rm $(PHP_SERVICE) composer --no-ansi show -o | tee tests/_log/composer-outdated-packages-$(shell cat ../src/version).txt || ERROR=1; \
	exit ${ERROR}

lint-html:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  validator http://web

lint-links:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  linkchecker linkchecker http://web -F html/utf8/./tmp/tests/_log/check.html -f /tmp/tests/linkcheckerrc -r 3 -t 5

lint: lint-source lint-composer





# Help based on https://gist.github.com/prwhite/8168133 thanks to @nowox and @prwhite
# And add help text after each target name starting with '\#\#'
# A category can be added with @category

HELP_FUN = \
		%help; \
		while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([\w-]+)\s*:.*\#\#(?:@([\w-]+))?\s(.*)$$/ }; \
		print "\nusage: make [target ...]\n\n"; \
	for (keys %help) { \
		print "$$_:\n"; \
		for (@{$$help{$$_}}) { \
			$$sep = "." x (25 - length $$_->[0]); \
			print "  $$_->[0]$$sep$$_->[1]\n"; \
		} \
		print "\n"; }

help: ##@system show this help
	#
	# General targets
	#
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)
