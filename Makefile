# Variables

ENVVARS=$(shell cat .env | grep -v ^\#)

target_container    ?= php
php_sources         ?= .
phpcs_ignored_files ?= vendor/*,var/cache/*

mysql_container_name = $(shell docker-compose ps |grep '^[a-Z-]*-mysql' |sed 's/-mysql .*/-mysql/')

reverse_proxy_container_name = "reverse-proxy"
reverse_proxy_container_id = $(shell docker ps -q -f name="$(reverse_proxy_container_name)")

network_name = $(shell $(ENVVARS) && echo "$$NETWORK_NAME")
network_id = $(shell docker network ls -q -f name="^$(network_name)$$")
project_hosts= $(shell cat .env | grep -v ^\# | grep -oP "HOST=\K(.*+)" | tr "," " ")

default: pbc

*: .env

# Bash Commands

.env:
	cp .env.dist .env

.PHONY: command
command:
	docker-compose run --rm $(target_container) $(cmd)

.PHONY: bash
bash:
	docker-compose exec '$(target_container)' bash

.PHONY: root
root:
	@if [ "root" != "$(shell whoami)" ]; then \
		echo "You have to be root"; \
		exit 1; \
	fi

# MYSQL

.PHONY: mysql-export
mysql-export:
	docker exec -i $(mysql_container_name) bash -c 'mysqldump -p$$MYSQL_PASSWORD -u$$MYSQL_USER $$MYSQL_DATABASE' > $(path)

.PHONY: mysql-import
mysql-import:
	docker exec -i $(mysql_container_name) bash -c 'mysql -p$$MYSQL_PASSWORD -u$$MYSQL_USER $$MYSQL_DATABASE' < $(path)


# UTILS

.PHONY: composer-update
composer-update: network
	docker-compose run --rm php composer update $(options)

.PHONY: composer-install
composer-install: network
	docker-compose run --rm php composer install $(options)

.PHONY: phploc
phploc:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phploc $(php_sources); exit $$?'

.PHONY: phpcs
phpcs:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpcs $(php_sources) --extensions=php --ignore=$(phpcs_ignored_files) --standard=PSR2; exit $$?'

.PHONY: phpcpd
phpcpd:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpcpd $(php_sources); exit $$?'

.PHONY: phpdcd
phpdcd:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpdcd $(php_sources); exit $$?'

.PHONY: phpcs-fix
phpcs-fix:
	docker run --rm -i -v `pwd`:`pwd` -w `pwd` grachev/php-cs-fixer --rules=@Symfony --verbose fix $(php_sources)

# SYMFONY BUNDLE

.PHONY: phpunit
phpunit: ./vendor/bin/phpunit
	docker-compose run --rm php ./vendor/bin/phpunit

.PHONY: phpunit-text
phpunit-text: ./vendor/bin/phpunit
	docker-compose run --rm php ./vendor/bin/phpunit --coverage-text

.PHONY: phpunit-html
phpunit-html: ./vendor/bin/phpunit
	docker-compose run --rm php ./vendor/bin/phpunit --coverage-html phpunit-html

# SYMFONY APP

.PHONY: pbc
pbc:
	docker-compose run --rm php php bin/console $(cmd)

.PHONY: deploy-preprod
deploy-preprod:
	ansible-playbook deploy/deploy-pre-prod.yml --ask-pass

.PHONY: deploy-prod
deploy-prod:
	ansible-playbook deploy/deploy-prod.yml --ask-pass

# NETWORK

.PHONY: network
network:
	@if [ -z "$(network_id)" ]; then \
		docker network create $(network_name); \
	fi

# PROXY

.PHONY: start-reverse-proxy
start-reverse-proxy: network
	@if [ -z "$(reverse_proxy_container_id)" ]; then \
		printf "\nCreating and starting '$(reverse_proxy_container_name)'"; \
		docker run -d --rm \
			--name "$(reverse_proxy_container_name)" \
			--publish="80:80" \
			-v "/var/run/docker.sock:/tmp/docker.sock:ro" \
			-v "$(shell pwd)/.docker/nginx/proxy.conf:/etc/nginx/conf.d/proxy.conf:ro" \
			jwilder/nginx-proxy \
		; \
       	fi

.PHONY: attaching-reverse-proxy-network
attaching-reverse-proxy-network: start-reverse-proxy
	@printf "\nAttaching '$(reverse_proxy_container_name)' to '$(network_name)'";
	@docker network connect $(network_name) $(reverse_proxy_container_name) | exit 0

.PHONY: stop-reverse-proxy
stop-reverse-proxy:
	@if [ -n "$(reverse_proxy_container_id)" ]; then \
		printf "\nStoping '$(reverse_proxy_container_name)'"; \
		docker stop "$(reverse_proxy_container_name)"; \
       	fi


.PHONY: install-hosts
install-hosts: root
	@if [ -z "$(shell grep "$(project_hosts)" /etc/hosts)" ]; then \
		echo "Install hosts"; \
		printf "127.0.0.1\t$(project_hosts)" >> "/etc/hosts"; \
	fi

.PHONY: uninstall-hosts
uninstall-hosts: root
	@to_remove="$(shell grep -P "(\d+\.){3}(\d+)\t$(project_hosts)" "/etc/hosts")"; \
	if [ -n "$$to_remove" ]; then \
		echo "Uninstall hosts"; \
		ex -s -c "g/$$to_remove/d" -c "wq" "/etc/hosts"; \
	fi

# PROJECT

.PHONY: start
start: attaching-reverse-proxy-network network
	@printf "\nStarting project"
	@docker-compose up -d

.PHONY: stop
stop: stop-reverse-proxy
	@printf "\nStoping project"
	@docker-compose stop
