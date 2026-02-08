#!/bin/sh
set -e

php artisan migrate --force

php artisan queue:work --tries=3 --sleep=3 &

exec php artisan octane:start --server=roadrunner --host=0.0.0.0 --port=8000
