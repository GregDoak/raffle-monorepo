default: help
SHELL := /bin/bash
ENV_FILE := ./../.env

ifeq (,$(wildcard ${ENV_FILE}))
$(error ${ENV_FILE} is missing)
endif

include ${ENV_FILE}
DOCKER_COMPOSE := docker compose --project-name "${PROJECT_NAME}-shared" --file "docker-compose.yaml" --env-file=${ENV_FILE}

.PHONY: destroy
destroy: ## Destroys the local environment
	@${DOCKER_COMPOSE} down --volumes

.PHONY: restart
restart: stop start ## Restarts the local environment

.PHONY: start
start: ## Starts the local environment
	@${DOCKER_COMPOSE} up --build --remove-orphans

.PHONY: stop
stop: ## Stops the local environment
	@${DOCKER_COMPOSE} stop

.PHONY: help
help:
	@printf "Available targets:\n"
	@awk 'BEGIN {FS = ":.*##"} /^[a-zA-Z\/_-]+:.*?##/ { \
		printf "  \x1b[32;01m%-35s\x1b[0m %s\n", $$1, $$2 \
		} /^##@/ { printf "\n\033[1m%s\033[0m\n", $$0 } ' \
		$(MAKEFILE_LIST) | sort -u
	@printf "\n"
