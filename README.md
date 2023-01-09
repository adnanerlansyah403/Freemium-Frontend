
# Freemium App 

## initiate 

1. composer update
2. cp .env.example .env (buat munculin file .env nya)
3. php artisan key:migrate (buat bikin secret code)
4. isi file .env dan sesuaikan dengan database yang ingin di gunakan
5. php artisan migrate
6. config .env <br>
    -DB_CONNECTION=pgsql 
    -DB_HOST=127.0.0.1 
    -DB_PORT=5432 
    -DB_DATABASE=nama_database 
    -DB_USERNAME=postgres 
    -DB_PASSWORD=password
