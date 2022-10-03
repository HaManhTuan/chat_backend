reinstall:
	- make delete
	- make install
up:
	- docker-compose up -d
install:
	- cp .env.local .env
	- docker-compose up -d --build
restart:
	- make stop
	- make up
stop:
	docker-compose down
pull:
	- git pull
	- make migrate
lints:
	docker exec -it chat_app npm run lint
queue:
	docker exec -it chat_app php artisan queue:work
queue-restart:
	docker exec -it chat_app supervisorctl restart all
#
init-app:
	docker exec -it chat_app composer install
	docker exec -it chat_app php artisan key:generate
	docker exec -it chat_app php artisan migrate
	docker exec -it chat_app php artisan db:seed
	docker exec -it chat_app chmod -R 777 storage bootstrap
	docker exec -it chat_app php artisan cache:clear
	docker exec -it chat_app php artisan view:clear
	docker exec -it chat_app php artisan config:clear
update-code:
	git pull
	make migrate
	make build
	make clear
build-test:
	git pull
	cp .env.testing .env
	docker-compose -f docker-compose.yml.test up -d --build
	make init-app
build-stg:
	git pull
	cp .env.stg .env
	docker-compose -f docker-compose.yml.stg up -d --build
	make build
build-prod:
	git pull
	cp .env.prod .env
	docker-compose -f docker-compose.yml.prod up -d --build
	make build
build-batch:
	git pull
	docker-compose -f docker-compose.yml.batch up -d --build
	docker exec -it chat_app php artisan config:clear
update-batch:
	- make pull
	- docker exec -it chat_app php artisan config:clear
	- docker exec -it chat_app php artisan cache:clear
	- make queue-restart
migrate:
	docker exec -it chat_app php artisan migrate
seed:
	docker exec -it chat_app php artisan db:seed
reseed:
	- docker exec -it chat_app php artisan migrate:reset
	- docker exec -it chat_app php artisan migrate
	- docker exec -it chat_app php artisan db:seed
delete:
	- docker-compose stop
	- docker-compose down
	- docker rm $(shell docker ps -la  | grep '${APP_NAME}' | awk '{print $1}')
	- docker rmi $(shell docker images -a -q)
tinker:
	docker exec -it chat_app php artisan tinker
conn:
	docker exec -it chat_app bash
batch:
	cp docker-compose.yml.prod.batch docker-compose.yml
	cp .env.prod .env
	docker-compose up -d --build
	docker exec -it chat_app composer install
	docker exec -it chat_app chmod -R 777 storage bootstrap
	docker exec -it chat_app php artisan config:cache
web:
	cp docker-compose.yml.prod.batch docker-compose.yml
	cp .env.prod .env
	docker-compose up -d --build
	make init-app
clear:
	docker exec -it chat_app php artisan config:clear
	docker exec -it chat_app php artisan cache:clear
	docker exec -it chat_app php artisan view:clear
