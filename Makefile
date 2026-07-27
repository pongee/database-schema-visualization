.DEFAULT_GOAL := help
.PHONY: install test phpstan phpcs phpcbf rector rector-dry-run check docker-build docker-buildx help

IMAGE ?= database-schema-visualization
PLATFORMS ?= linux/amd64,linux/arm64

install: ## Install composer dependencies
	composer install

test: ## Run the test suite
	composer run-script test

phpstan: ## Run static analysis
	composer run-script phpstan

phpcs: ## Run coding standard checks
	composer run-script phpcs

phpcbf: ## Fix coding standard violations
	vendor/bin/phpcbf

rector: ## Apply rector rules
	composer run-script rector

rector-dry-run: ## Show rector changes without applying them
	composer run-script rector-dry-run

docker-build: ## Build the Docker image for the local platform
	docker build -t $(IMAGE) .

docker-buildx: ## Build the image for amd64 and arm64 (set PUSH=1 to push)
	docker buildx build --platform $(PLATFORMS) $(if $(PUSH),--push,) -t $(IMAGE) .

check: ## Run every CI check (test, phpstan, rector, phpcs)
	$(MAKE) test
	$(MAKE) phpstan
	$(MAKE) rector-dry-run
	$(MAKE) phpcs

help: ## Show commands
	@echo "\033[33mUsage:\033[0m\n make [command]\n\n\033[33mCommands:\033[0m"
	@MAX=$$( \
		grep -hE '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk -F':.*?## ' '{ if (length($$1) > max) max = length($$1) } END { print max+1 }' \
	); \
	grep -hE '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | uniq | \
	awk -F':.*?## ' -v max="$$MAX" '{ printf "  \033[32m%-" max "s\033[0m %s\n", $$1, $$2 }'
