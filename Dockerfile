# syntax=docker/dockerfile:1

# --- Install PHP dependencies -------------------------------------------------
FROM php:8.5-cli-alpine AS build

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache git unzip

WORKDIR /app
COPY . .
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# --- Runtime ------------------------------------------------------------------
FROM php:8.5-cli-alpine

# openjdk + graphviz + fonts are needed by the mysql:image (PlantUML) command.
RUN apk add --no-cache openjdk21-jre-headless graphviz ttf-dejavu

WORKDIR /app
COPY --from=build /app /app
RUN mkdir -p tmp

ENTRYPOINT ["php", "/app/database-schema-visualization"]
CMD ["list"]
