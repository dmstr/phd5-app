include ../Makefile.base

all: ##@test [TEST] shorthand for
	$(MAKE) version build
	$(MAKE) clean up setup

version:
	$(shell echo $(shell git describe --long --tags --dirty --always) > ../src/version)
	@echo $(shell cat ../src/version)

bash: ##@development open application development bash
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test php bash

bash-xdebug: ##@development open application development bash with xdebug enabled
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 php bash

run-tests: ##@test run tests
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test php sh -c 'codecept clean'
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test php sh -c 'chmod -R 777 /root/.composer && codecept run -x optional --steps --html --xml --tap --json'

run-coverage: ##@test run tests
	$(DOCKER_COMPOSE) run --rm -e YII_ENV=test -e PHP_ENABLE_XDEBUG=1 php sh -c 'chmod -R 777 /root/.composer && codecept run -x optional --coverage-html --html=_report-coverage.html'

open-vnc: ##@test open application database service in browser
	$(OPEN_CMD) vnc://x:secret@$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port firefox 5900 | sed 's/[0-9.]*://')

open-report: ##@test open HTML reports
	$(OPEN_CMD) codeception/_output/_report.html

open-coverage: ##@test open HTML reports
	$(OPEN_CMD) codeception/_output/coverage/index.html

open-c3:
	$(OPEN_CMD) http://$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port web 80 | sed 's/[0-9.]*://')/c3/report/clear