init:
	cp .env.example .env
	docker run --rm -u "$(shell id -u):$(shell id -g)" \
		-v "$(shell pwd):/var/www/html" \
		-w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs
	./vendor/bin/sail up -d
	./vendor/bin/sail composer install
	./vendor/bin/sail npm install
	make install
	./vendor/bin/sail php artisan key:generate
	./vendor/bin/sail php artisan storage:link
	make redb
	make up

start:
	sudo service docker start

stop:
	sudo service docker stop

restart:
	sudo service docker restart

up:
	./vendor/bin/sail up -d
	./vendor/bin/sail npm run dev

up-build:
	./vendor/bin/sail up -d
	./vendor/bin/sail npm run build

down:
	./vendor/bin/sail down

install:
	 ./vendor/bin/sail composer install
	 ./vendor/bin/sail npm install

migrate:
	 ./vendor/bin/sail artisan migrate

redb:
	 ./vendor/bin/sail artisan migrate:fresh --seed

route:
	 ./vendor/bin/sail artisan route:list

test:
	 ./vendor/bin/sail artisan test

check-php:
	 ./vendor/bin/sail php ./vendor/bin/phpstan analyze .

user:
	sudo chown -R $(shell whoami):$(shell whoami) .