.PHONY: up down build rebuild logs shell-backend shell-frontend migrate seed composer npm test clear-cache install

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

rebuild:
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d

logs:
	docker-compose logs -f

shell-backend:
	docker-compose exec backend sh

shell-frontend:
	docker-compose exec frontend sh

migrate:
	docker-compose exec backend php artisan migrate

seed:
	docker-compose exec backend php artisan db:seed

composer:
	docker-compose exec backend composer $(cmd)

artisan:
	docker-compose exec backend php artisan $(cmd)

npm:
	docker-compose exec frontend npm $(cmd)

test:
	docker-compose exec backend php artisan test

clear-cache:
	docker-compose exec backend php artisan cache:clear
	docker-compose exec backend php artisan config:clear
	docker-compose exec backend php artisan route:clear
	docker-compose exec backend php artisan view:clear

install: up
	docker-compose exec backend composer install
	docker-compose exec frontend npm install
