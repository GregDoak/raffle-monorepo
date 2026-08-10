default: help
SHELL := /bin/bash
MAKE := make --no-print-directory

ifeq (,$(wildcard .env))
$(shell cp .env.template .env)
endif

.PHONY: destroy
destroy: stop ## Destroys the local environment of the full stack
	@${MAKE} -j2 shared/destroy backend/destroy

.PHONY: restart
restart: stop start ## Restarts the local environment of the full stack

.PHONY: start
start: stop ## Starts the local environment of the full stack
	@${MAKE} -j2 shared/start backend/start-alone

.PHONY: stop
stop: ## Stops the local environment of the full stack
	@${MAKE} -j2 shared/stop backend/stop

.PHONY: backend/shell
backend/shell: ## Shell into the default backend service
	@cd backend && ${MAKE} shell

.PHONY: backend/destroy
backend/destroy: ## Destroys the development environment of the backend service
	@cd backend && ${MAKE} destroy

.PHONY: backend/start
backend/start: ## Starts the development environment of the backend service with shared services
	@${MAKE} -j2 shared/start backend/start-alone

.PHONY: backend/start-alone
backend/start-alone: ## Starts the development environment of the backend service as stand alone
	@cd backend && ${MAKE} start

.PHONY: backend/stop
backend/stop: ## Stops the development environment of the backend service
	@cd backend && ${MAKE} stop

.PHONY: shared/destroy
shared/destroy: ## Destroys the local environment of the shared services
	@cd shared && ${MAKE} destroy

.PHONY: shared/start
shared/start: ## Starts the local environment of the shared services
	@cd shared && ${MAKE} start

.PHONY: shared/stop
shared/stop: ## Stops the local environment of the shared services
	@cd shared && ${MAKE} stop

.PHONY: help
help:
	@printf "Available targets:\n"
	@awk 'BEGIN {FS = ":.*##"} /^[a-zA-Z\/_-]+:.*?##/ { \
		printf "  \x1b[32;01m%-35s\x1b[0m %s\n", $$1, $$2 \
		} /^##@/ { printf "\n\033[1m%s\033[0m\n", $$0 } ' \
		$(MAKEFILE_LIST)
	@printf "\n"
