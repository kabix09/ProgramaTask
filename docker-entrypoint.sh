#!/bin/sh
set -e

DB_HOST=${DB_HOST:-database}
DB_PORT=${DB_PORT:-5432}

echo "Waiting for database at $DB_HOST:$DB_PORT..."

until nc -z "$DB_HOST" "$DB_PORT"; do
  echo "Database is unavailable - sleeping"
  sleep 1
done

echo "Database is up - executing migrations"

php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

exec "$@"
