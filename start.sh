#!/bin/bash

echo "########### Creating Application container"
docker-compose up -d

echo "########### Copying the configuration example file"
docker exec -it test-app cp .env.example .env

echo "########### Install dependencies"
docker exec -it test-app composer install

echo "########### Generate key"
docker exec -it test-app php artisan key:generate

echo "########### Make migrations"
docker exec -it test-app php artisan migrate

echo "########### Make seeds"
docker exec -it test-app php artisan db:seed

echo "########### Information of new containers"
docker ps -a

echo "########### Make tests"
docker exec -it test-app vendor/bin/phpunit