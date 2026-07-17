#!/usr/bin/env bash
set -e
echo "Installation et lancement de Vite & Gourmand"
docker compose up -d
php -S localhost:8000 -t public
