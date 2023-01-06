## initiate 

1. composer update
2. composer install
3. composer update
4. php artisan storage:link
5. cp .env.example .env (buat munculin file .env nya)
6. php artisan key:migrate (buat bikin secret code)
7. isi file .env supaya ngikutin database kamu
8. php artisan migrate
9. config env DB_CONNECTION=pgsql DB_HOST=127.0.0.1 DB_PORT=5432 DB_DATABASE=nama_database_maneh DB_USERNAME=postgres DB_PASSWORD=password_maneh
