
# Freemium App 

## initiate 

1. composer update
2. php artisan storage:link
3. cp .env.example .env (buat munculin file .env nya)
4. php artisan key:migrate (buat bikin secret code)
5. isi file .env supaya ngikutin database kamu
6. php artisan migrate
7. config env DB_CONNECTION=pgsql DB_HOST=127.0.0.1 DB_PORT=5432 DB_DATABASE=nama_database_maneh DB_USERNAME=postgres DB_PASSWORD=password_maneh
