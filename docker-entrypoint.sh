#!/bin/sh
set -e

DB_HOST=${DB_HOST:-database}
DB_PORT=${DB_PORT:-5432}

echo "Waiting for database at $DB_HOST:$DB_PORT..."

until nc -z "$DB_HOST" "$DB_PORT"; do
  echo "Database is unavailable - sleeping"
  sleep 1
done

echo "Database is up!"

if [ ! -f config/jwt/private.pem ]; then
    echo "JWT keys not found. Generating new keypair..."
    mkdir -p config/jwt

    php bin/console lexik:jwt:generate-keypair --skip-if-exists

    chown -R www-data:www-data config/jwt
    chmod 600 config/jwt/private.pem
    echo "JWT keys generated successfully."
fi

echo "Executing migrations..."
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

echo "Clearing cache..."
php bin/console cache:clear --no-interaction

echo "Entrypoint finished. Starting application..."

exec "$@"
