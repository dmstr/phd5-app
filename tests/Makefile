include ../Makefile.base

TESTER_SERVICE=php
BROWSER_SERVICE=firefox

all: ##@test [TEST] shorthand for
	$(MAKE) version build
	$(MAKE) clean up setup

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
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) sh -c 'codecept clean'
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) sh -c 'chmod -R 777 /root/.composer && codecept run -x optional --steps --html --xml --tap --json'
	$(DOCKER_COMPOSE) logs $(PHP_SERVICE) > _log/docker.log

run-coverage: ##@test run tests with code coverage
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test $(TESTER_SERVICE) sh -c 'codecept clean'
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 $(TESTER_SERVICE) sh -c 'chmod -R 777 /root/.composer && codecept run -x optional --coverage-html --coverage-xml --html --xml'

open-vnc: ##@test open application database service in browser
	$(OPEN_CMD) vnc://x:secret@$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port $(BROWSER_SERVICE) 5900 | sed 's/[0-9.]*://')

open-report: ##@test open HTML reports
	$(OPEN_CMD) codeception/_output/_report.html

open-coverage: ##@test open HTML reports
	$(OPEN_CMD) codeception/_output/coverage/index.html

open-c3:
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port web 80 | sed 's/[0-9.]*://')/c3/report/clear