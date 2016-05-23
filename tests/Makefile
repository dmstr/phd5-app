include ../Makefile

test:	 ##@docker open application web service in browser
	$(DOCKER_COMPOSE) run -e YII_ENV=test php codecept run -g mandatory --html=_report_mandatory.html
