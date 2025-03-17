#!/usr/bin/make
SHELL = /bin/sh
.PHONY: help
.DEFAULT_GOAL := help

PROJECT_NAME = php-ddd

COMPOSE = docker compose -p $(PROJECT_NAME) -f docker/docker-compose.yml
EXEC = docker exec -it php_fpm

#help: @ List available commands on this project
help:
	@grep -E '[a-zA-Z\.\-\/]+:.*?@ .*$$' $(MAKEFILE_LIST)| tr -d '#' | awk 'BEGIN {FS = ":.*?@ "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

#build: @ Build docker images
build:
	$(COMPOSE) build

#composer-install: @ Install composer dependencies
composer/install:
	$(EXEC) composer install

#up: @ Start all containers
up:
	$(COMPOSE) up -d --remove-orphans php_fpm nginx

#install: @ Set up the project
install:
	docker network inspect dev > /dev/null || docker network create dev
	make build
	make up
	make composer-install

#shell: @ Run the console inside the PHP container
shell:
	$(EXEC) /bin/sh

#psalm: @ Run psalm(static code analytic tool)
psalm:
	$(EXEC) vendor/bin/psalm --threads=1 --no-cache --no-diff --show-info=true

#psalm/baseline/update: @ update psalm baseline file (removes fixes)
psalm/baseline/update:
	$(EXEC) vendor/bin/psalm --threads=1 --no-cache --no-diff --show-info=true --update-baseline

#psalm/baseline/set: @ set psalm baseline file (add errors)
psalm/baseline/set:
	$(EXEC) vendor/bin/psalm --threads=1 --no-cache --no-diff --show-info=true --set-baseline=psalm-baseline.xml

#symfony/cc: @ clear symfony cache
symfony/cc:
	$(EXEC) php bin/console cache:clear

#test: @ Run tests without external dependencies
test:
	$(EXEC) vendor/bin/phpunit --exclude-group external

#test/all: @ Run all tests
test/all:
	$(EXEC) vendor/bin/phpunit

#test/unit: @ Run all unit tests
test/unit:
	$(EXEC) vendor/bin/phpunit --testsuite unit

#test/integration: @ Run integration tests
test/integration:
	$(EXEC) vendor/bin/phpunit --testsuite integration --exclude-group external

#test/functional: @ Run functional tests
test/functional:
	$(EXEC) vendor/bin/phpunit --testsuite functional --exclude-group external

#test/coverage: @ Run test with coverage
test/coverage:
	$(EXEC) vendor/bin/phpunit --coverage-html coverage --coverage-filter src/ --exclude-group external
