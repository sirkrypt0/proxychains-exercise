FROM php:apache-buster

RUN apt update && apt install -y python3 netcat && rm -rf /var/lib/apt/lists/*

COPY python.php /var/www/html/index.php
