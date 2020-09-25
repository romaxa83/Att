Тестовое задание

в корне проекта файл коллекция для postman (Att.postman_collection.json)

команды для запуска
```
cp .env.example .env
make init (для докера развернет окружение)
composer install
php artisan key:generate
php artisan migrate
php artisan sync:data
```


если запуск идет через докер ,данная команда укажит какой домен для сайта
```
make info
```

