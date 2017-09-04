include ../Makefile.base

TESTER_SERVICE  ?= php
BROWSER_SERVICE ?= firefox
COMPOSE_FILE_QA ?= ../docker-compose.yml:./docker-compose.test.yml:./docker-compose.qa.yml

all: ##@test [TEST] shorthand for
	$(MAKE) init-tests version build
	$(MAKE) clean up setup

init-tests:
	mkdir -p _log/codeception && chmod -R 777 _log/codeception
	mkdir -p _log/lint && chmod -R 777 _log/lint

version:
	$(shell echo $(shell git describe --long --tags --dirty --always) > ../src/version)
	@echo $(shell cat ../src/version)

bash: ##@development open application development bash
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) bash

bash-xdebug: ##@development open application development bash with xdebug enabled
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 $(TESTER_SERVICE) bash

up-xdebug: ##@development open application development bash with xdebug enabled
	PHP_ENABLE_XDEBUG=1 $(DOCKER_COMPOSE) up -d

run-tests: ##@test run tests
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept clean
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept run -x optional --steps --html=_report.html --xml=_report.xml --tap=_report.tap --json=_report.json
	$(DOCKER_COMPOSE) logs $(PHP_SERVICE) > _log/docker.log

run-coverage: ##@test run tests with code coverage
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) codecept clean
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 $(TESTER_SERVICE) codecept run -x optional --coverage-html --coverage-xml --html --xml


open-vnc: ##@test open application database service in browser
	$(OPEN_CMD) vnc://x:secret@$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(BROWSER_SERVICE) 5900 | sed 's/[0-9.]*://')

open-report: ##@test open HTML reports
	$(OPEN_CMD) _log/codeception/_report.html

open-coverage: ##@test open HTML reports
	$(OPEN_CMD) _log/coverage/index.html

open-c3:
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port web 80 | sed 's/[0-9.]*://')/c3/report/clear


lint-source:	 ##@development run source-code linting
	#
	# Liniting source-code with cs-fixer, phpmetrics & phpmd
	#
	$(DOCKER_COMPOSE) run --rm php php-cs-fixer fix --format=txt -v --dry-run ../src
	docker run --rm -v "${PWD}/..:/app" --workdir=/app herloct/phpmetrics --report-html=tests/_log/lint/metrics --excluded-dirs=migrations src/
	docker run --rm -v "${PWD}/..:/project" jolicode/phaudit phpmd src html tests/phpmd/rulesets.xml --exclude src/migrations > _log/lint/mess.html
	exit ${ERROR}

lint-composer: ##@development run composer linting
	#
	# Liniting composer configuration
	#
	$(DOCKER_COMPOSE) run --rm php composer --no-ansi validate || ERROR=1; \
	$(DOCKER_COMPOSE) run --rm php composer --no-ansi show || ERROR=1; \
	$(DOCKER_COMPOSE) run --rm php composer --no-ansi show -o || ERROR=1; \
	exit ${ERROR}

lint-html:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  validator http://web

lint-links:
	COMPOSE_FILE=$(COMPOSE_FILE_QA) $(DOCKER_COMPOSE) run --rm  linkchecker linkchecker http://web -F html/utf8/./tmp/tests/_log/check.html -f /tmp/tests/linkcheckerrc -r 3 -t 5

lint: lint-source lint-composer
