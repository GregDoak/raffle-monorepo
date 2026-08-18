default: help
SHELL := /bin/bash
ENV_FILE := ./../.env

ifeq (,$(wildcard ${ENV_FILE}))
$(error ${ENV_FILE} is missing)
endif

include ${ENV_FILE}
DOCKER_COMPOSE := docker compose --project-name "${PROJECT_NAME}-backend" --file "docker-compose.yaml" --env-file=${ENV_FILE}

.PHONY: can-release
can-release: ## Runs all checks required for release
	@${DOCKER_COMPOSE} run -it --rm php make can-release

.PHONY: destroy
destroy: ## Destroys the local environment
	@${DOCKER_COMPOSE} down --volumes

.PHONY: restart
restart: stop start ## Restarts the local environment

.PHONY: build
build: ## Build the local environment
	@mkdir -p application/var/cache application/var/log
	@chmod -R u+rwX application/var/cache application/var/log
	@${DOCKER_COMPOSE} run -T --rm php composer install --no-interaction
	@${DOCKER_COMPOSE} run -T --rm php bin/console doctrine:database:create --if-not-exists
	@${DOCKER_COMPOSE} run -T --rm php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration --all-or-nothing

.PHONY: start
start: build ## Starts the local environment
	@${DOCKER_COMPOSE} up --build --remove-orphans

.PHONY: stop
stop: ## Stops the local environment
	@${DOCKER_COMPOSE} stop

.PHONY: shell
shell: ## Shell into the default service
	@${DOCKER_COMPOSE} run -it --rm php /bin/bash

.PHONY: help
help:
	@printf "Available targets:\n"
	@awk 'BEGIN {FS = ":.*##"} /^[a-zA-Z\/_-]+:.*?##/ { \
		printf "  \x1b[32;01m%-35s\x1b[0m %s\n", $$1, $$2 \
		} /^##@/ { printf "\n\033[1m%s\033[0m\n", $$0 } ' \
		$(MAKEFILE_LIST)
	@printf "\n"
