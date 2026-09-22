FROM php:8.3-cli

# Instala a extensão do PDO MySQL no PHP
RUN docker-php-ext-install pdo pdo_mysql