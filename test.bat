@echo off

docker exec -it --user root --workdir /app php-cookie-api bash -c "/app/vendor/bin/phpunit"
