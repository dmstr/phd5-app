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
all: init build install up setup browser
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


upgrade: ##@base update application package, pull, rebuild
	#
	# Running package upgrade in container
	# Note: If you have performance with this operation issues, please check the documentation under http://phd.dmstr.io/docs
	#
	$(DOCKER_COMPOSE) run --rm php composer -dsrc update -v

dist-upgrade: ##@base update application package, pull, rebuild
	$(DOCKER_COMPOSE) build --pull --build-arg BUILD_NO_INSTALL=1
	$(MAKE) upgrade
	$(MAKE) build

install: ##@base install PHP packages
	$(DOCKER_COMPOSE) run --rm php composer -dsrc  install

bash:	 ##@development execute application bash in one-off container
	#
	# Starting application bash
	#
	$(DOCKER_COMPOSE) exec php bash

cli:	 ##@development run application cli in one-off container
	#
	# Starting application CLI container
	#
	$(DOCKER_COMPOSE) run --rm --workdir=/app/src -e PHP_USER_ID=0 $(PHP_SERVICE) bash

assets:	 ##@development open application development bash
	#
	# Building asset bundles
	#
	$(DOCKER_COMPOSE) run --rm -e APP_ASSET_USE_BUNDLED=0 $(PHP_SERVICE) yii asset/compress config/assets.php web/bundles/config.php


init:    ##@development install composer package (enable host-volume in docker-compose config)
init:
	#
	# Running composer installation in development environment
	# This may take a while on your first install...
	#
	cp -n .env-dist .env &2>/dev/null
	touch config/local.env

setup: ##@development run application setup
	#
	# Running application setup command (database, user)
	#
	$(DOCKER_COMPOSE) run --rm $(PHP_SERVICE) yii app/setup

browser: ##@development open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(PHP_SERVICE) 80 | sed 's/[0-9.]*://') &>/dev/null


test: version build install up
test: ##@test run tests
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept clean
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept run --env $(BROWSER_SERVICE) -x optional --steps --html --xml= --tap --json
	$(DOCKER_COMPOSE) logs $(PHP_SERVICE) > _host-volumes/tests/_log/php.log
	$(DOCKER_COMPOSE) logs $(TESTER_SERVICE) > _host-volumes/tests/_log/tester.log

test-coverage: ##@test run tests with code coverage
	PHP_ENABLE_XDEBUG=1 $(DOCKER_COMPOSE) up -d
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) yii app/setup
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
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE)  bash

test-browser: ##@test open application web service in browser
	#
	# Opening application on mapped web-service port
	#
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(TESTER_SERVICE)  80 | sed 's/[0-9.]*://') &>/dev/null

test-selenium: ##@test open application database service in browser
	$(OPEN_CMD) vnc://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(BROWSER_SERVICE) 5900 | sed 's/[0-9.]*://') &>/dev/null

test-report: ##@test open HTML reports
	$(OPEN_CMD) _log/codeception/report.html &>/dev/null

test-report-coverage: ##@test open HTML reports
	$(OPEN_CMD) _log/coverage/index.html &>/dev/null


fix-source:	 ##@development fix source-code linting errors
	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Fixing source-code lint errors with cs-fixer
	#
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) php-cs-fixer fix --format=txt -v ../src

lint-source:	 ##@development run source-code linting
	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Liniting source-code with cs-fixer
	#
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) php-cs-fixer fix --format=txt -v --dry-run ../src

lint-metrics:	 ##@development run source-code metrics
	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Source-code metrics
	#
	docker run --rm -v "${PWD}:/app" -v "${PWD}/_host-volumes/tests-log:/app/tests/_log" --workdir=/app herloct/phpmetrics --report-html=tests/_log/lint/metrics --exclude=migrations,runtime src/
	docker run --rm -v "${PWD}:/project" -v "${PWD}/_host-volumes/tests-log/lint:/app/tests/_log/lint" jolicode/phaudit sh -c 'phpmd src html /project/tests/phpmd/rulesets.xml --exclude src/migrations | sudo tee /app/tests/_log/lint/mess.html'

lint-composer: ##@development run composer linting
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) mkdir -p _log/composer

	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Liniting composer configuration
	#
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) composer -d../src --no-ansi validate

	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Listing installed packages
	#
	$(DOCKER_COMPOSE) run --rm $(TESTER_SERVICE) sh -c 'composer -d../src --no-ansi show -f json | tee _log/composer/packages-$(shell cat ./src/version).json'

	# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	#
	# Listing outdated packages
	#
	$(DOCKER_COMPOSE) run -T --rm $(TESTER_SERVICE) sh -c 'composer  -d../src --no-ansi show -o -f json | grep -zo "\{.*\}" | tee _log/composer/outdated-packages-$(shell cat ./src/version).json'


lint-html:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  validator http://web

lint-links:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  linkchecker linkchecker http://web -F html/utf8/./tmp/tests/_log/check.html -f /tmp/tests/linkcheckerrc -r 3 -t 5

lint: version install lint-source lint-metrics lint-composer





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
