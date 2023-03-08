
## Installation guide

```shell
git clone git@github.com:/reneravoala/laravel-inertia-redis-chat.git
cd praxis_backend

composer install
npm install
npm run build

cp .env.example .env

php artisan key:generate
```

## Setup .env file

```shell
# Database connection setup 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=user
DB_PASSWORD=password

#Redis connection setup
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Migration

```shell
php artisan migrate
```

## Launch

```shell
php artisan serve

#Launch node server to listen to redis (will show an error if redis is not working)
node socket.js
```
