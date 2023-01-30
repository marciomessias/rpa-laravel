## Instrução para subir ambiente de desenvolvimento

- cp .env.example .env
- docker-compose up -d
- docker exec laravel php artisan schedule:work