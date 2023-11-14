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
composer-install:
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
