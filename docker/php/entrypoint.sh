#!/bin/sh
set -e

cd /var/www/html

copy_if_missing() {
  source_dir="$1"
  target_dir="$2"

  if [ ! -d "$target_dir" ] || [ -z "$(find "$target_dir" -mindepth 1 -maxdepth 1 2>/dev/null | head -n 1)" ]; then
    mkdir -p "$target_dir"
    cp -a "$source_dir"/. "$target_dir"/
  fi
}

ensure_env_file() {
  if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
  fi

  if [ -f .env ]; then
    sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env || true
    sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env || true
    if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
      php artisan key:generate --force --ansi >/dev/null 2>&1 || true
    fi
  fi
}

copy_if_missing /opt/vendor vendor
copy_if_missing /opt/public-build public/build
ensure_env_file

mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache vendor public/build || true

php artisan package:discover --ansi >/dev/null 2>&1 || true
php artisan storage:link --force >/dev/null 2>&1 || true
php artisan migrate --force --no-interaction || true

exec "$@"
