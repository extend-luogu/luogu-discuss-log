FROM php:fpm-alpine

RUN [ "docker-php-ext-install", "mysqli" ]

COPY . .
RUN [ "mv", "config_docker.php", "config.php" ]
