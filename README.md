## Instruções para subir ambiente de desenvolvimento

- cp .env.example .env
- docker volume create --name=selenium
- docker-compose up --build -d
- docker exec laravel php artisan key:generate
- docker exec laravel php artisan migrate
### Listagem dos comandos para executar robôs (Iniciados com rpa:)
- docker exec laravel php artisan list