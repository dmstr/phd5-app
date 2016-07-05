include ../Makefile.base

all:	 ##@test [TEST] shorthand for
	$(MAKE) -C .. build
	$(MAKE) clean up setup run-tests

bash:	 ##@development open application development bash
	$(DOCKER_COMPOSE) run -e YII_ENV=test php bash

run-tests:	 ##@test run tests
	$(DOCKER_COMPOSE) run -e YII_ENV=test php codecept run -g mandatory --html=_report_mandatory.html

open-vnc:	 ##@test open application database service in browser
	$(OPEN_CMD) vnc://x:secret@$(DOCKER_HOST_IP):$(shell $(DOCKER_COMPOSE) port firefox 5900 | sed 's/[0-9.]*://')

open-report: ##@test open HTML reports
	$(OPEN_CMD) codeception/_output/_report_mandatory.html