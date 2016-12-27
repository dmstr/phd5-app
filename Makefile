.PHONY: build test

include ./Makefile.base

all:    ##@development shorthand for 'build init up setup open'
all: init build dev up setup open

dev:    ##@development shorthand for 'up setup open'
dev:
	$(DOCKER_COMPOSE) run --rm php composer install

init:   ##@development initialize development environment
	cp -n .env-dist .env &2>/dev/null
	cp -n tests/.env-dist tests/.env &2>/dev/null
	cp -n src/app.env-dist src/app.env &2>/dev/null
	mkdir -p web/assets runtime



bash:	 ##@development open application development bash
	$(DOCKER_COMPOSE) run --rm php bash

upgrade: ##@development update application package, pull, rebuild
	$(DOCKER_COMPOSE) run --rm php composer update -v
	$(DOCKER_COMPOSE) build --pull

assets:	 ##@development open application development bash
	$(DOCKER_COMPOSE) run --rm -e APP_ASSET_USE_BUNDLED=0 php yii asset/compress src/config/assets.php web/bundles/config.php

latest: ##@development push to latest/release branch
	git push origin master:latest

lint:	 ##@development run source-code linting
	mkdir -p _artifacts/lint && chmod -R 777 _artifacts/lint
	docker run --rm -v "${PWD}:/project" jolicode/phaudit php-cs-fixer fix --format=txt -v --dry-run src || export ERROR=1; \
	docker run --rm -v "${PWD}:/project" jolicode/phaudit phpmetrics --report-html=_artifacts/lint/metrics.html --excluded-dirs=migrations src/ || ERROR=1; \
	docker run --rm -v "${PWD}:/project" jolicode/phaudit phpmd src html cleancode,codesize,controversial,design,unusedcode,tests/phpmd/naming.xml --exclude src/migrations > _artifacts/lint/mess.html || ERROR=1; \
	exit ${ERROR}

lint-composer: ##@development run composer linting
	docker-compose run --rm php composer --no-ansi validate || ERROR=1; \
	docker-compose run --rm php composer --no-ansi show || ERROR=1; \
	docker-compose run --rm php composer --no-ansi show -o || ERROR=1; \
	exit ${ERROR}
