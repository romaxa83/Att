.SILENT:

include .env
#==========VARIABLES================================================

site = http://192.168.151.1
php_container = php
node_container = node
db_container = db
web_container = web

#==========MAIN_COMMAND=============================================

up: docker_up info
restart: down build up info
init: down cp-env build docker_up app_init info
test: test_run
sync: sync_data


#==========COMMAND==================================================

build:
	docker-compose build

docker_up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans #очистит все запущеные контейнеры

sync_data:
	docker-compose exec $(php_container) php artisan sync:data

permission:
	sudo chmod 777 -R -f vendor/
	sudo chmod 777 -R -f docker/storage
	sudo chmod 777 -R -f storage

app_init:
	docker-compose exec $(php_container) composer install
	docker-compose exec $(php_container) php artisan key:generate
	docker-compose exec $(php_container) php artisan migrate
	docker-compose exec $(php_container) php artisan db:seed
# 	docker-compose exec $(php_container) php artisan sync:data

info:
	echo "$(site)"

cp-env:
	cp .env.example .env

api_docs:
	docker-compose exec $(php_container) php artisan l5-swagger:generate
	sudo chmod 777 -R storage/api-docs
#===================FRONT==============================================

npm_init:
	docker-compose exec $(nodejs_container) npm install
	sudo chmod 777 -R node_modules

watch:
	docker-compose exec $(nodejs_container) npm run watch

#===================INTO_CONTAINER======================================

php_bash:
	docker-compose exec $(php_container) bash

node_bash:
	docker exec -it $(nodejs_container) bash

db_bash:
	docker exec -it $(db_container) bash

web_bash:
	docker exec -it $(web_container) bash

#===================TEST================================================

test_init:
	cp .env.testing.dist .env.testing
	docker-compose exec $(php_container) php artisan key:generate --env=testing -n
	docker-compose exec $(php_container) php artisan migrate -n --env=testing
	docker-compose exec $(php_container) php artisan db:seed -n --env=testing
	docker-compose exec $(php_container) php artisan jd:create:admin c --env=testing
	docker-compose exec $(php_container) php artisan passport:test --env=testing
