UID                    = $(shell id -u)
GID                    = $(shell id -g)
UNAME                  = $(shell id -un)

BUILD_ARGS       = --build-arg UID=$(UID) \
                   --build-arg GID=$(GID) \
                   --build-arg UNAME=$(UNAME)

ROOT_DIR ?= $(PWD)
CONTAINER_HOME = /home/$(UNAME)

dev: \
    build \
    run-dev

test: \
    build \
	run-tests

test-ci: \
    build \
 	run-tests-ci

build:
	@docker build $(BUILD_ARGS) -t php docker

run-dev:
	@docker run \
                --rm \
                -ti \
                -v $(ROOT_DIR):/var/www/twitter-hashtag-frequency \
                -v $(HOME)/.composer:$(CONTAINER_HOME)/.composer \
                --name php \
                php \
                /bin/bash

run-tests:
	@docker run \
                --rm \
                -ti \
                -v $(ROOT_DIR):/var/www/twitter-hashtag-frequency \
                -v $(HOME)/.composer:$(CONTAINER_HOME)/.composer \
                --name php \
                php \
                /bin/bash -c "composer install && composer test"

run-tests-ci:
	@docker run \
                --rm \
                -ti \
                -v $(ROOT_DIR):/var/www/twitter-hashtag-frequency \
                -v $(HOME)/.composer:$(CONTAINER_HOME)/.composer \
                --name php \
                php \
                /bin/bash -c "composer install && composer test-ci"

hashtag-frequency: \
    build
	@docker run \
                --rm \
                -ti \
                -v $(ROOT_DIR):/var/www/twitter-hashtag-frequency \
                -v $(HOME)/.composer:$(CONTAINER_HOME)/.composer \
                --name php \
                php \
                /bin/bash -c "composer install && ./bin/console hashtag:frequency $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))"