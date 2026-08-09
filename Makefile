default: help
SHELL := /bin/bash
MAKE := make --no-print-directory

ifeq (,$(wildcard .env))
$(shell cp .env.template .env)
endif

.PHONY: destroy
destroy: stop ## Destroys the local environment of the full stack
	@${MAKE} -j1 shared/destroy

.PHONY: restart
restart: stop start ## Restarts the local environment of the full stack

.PHONY: start
start: stop ## Starts the local environment of the full stack
	@${MAKE} -j1 shared/start

.PHONY: stop
stop: ## Stops the local environment of the full stack
	@${MAKE} -j1 shared/stop

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
		$(MAKEFILE_LIST) | sort -u
	@printf "\n"
