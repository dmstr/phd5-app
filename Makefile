.PHONY: build test

include ./Makefile.base

all:    ##@development shorthand for 'build init up setup open'
all: build init up setup open

dev:    ##@development shorthand for 'up setup open'
dev: up setup open

init:   ##@development initialize development environment
	cp -n .env-dist .env &2>/dev/null
	cp -n tests/.env-dist tests/.env &2>/dev/null
	cp -n src/app.env-dist src/app.env &2>/dev/null
	$(DOCKER_COMPOSE) run --rm php composer install
	mkdir -p web/assets runtime

release: ##@development push to latest/release branch
	git push origin master:latest
