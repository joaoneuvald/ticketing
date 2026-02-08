#!/bin/sh
set -e

echo "=== Instalando Laravel Octane ==="

composer install --no-interaction

printf "1\nyes\n" | php artisan octane:install

if [ -f "./vendor/bin/rr" ]; then
    echo "=== Baixando RoadRunner binário ==="
    ./vendor/bin/rr get-binary -n --ansi
else
    echo "Arquivo ./vendor/bin/rr não encontrado. Certifique-se de que spiral/roadrunner-cli está instalado."
fi

echo "=== Octane + RoadRunner instalado com sucesso ==="
