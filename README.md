Тестовое задание

в корне проекта файл коллекция для postman (Att.postman_collection.json)

команды для запуска
```
cp .env.example .env
make init (для докера развернет окружение)
composer install
php artisan key:generate
php artisan migrate
sudo chmod 777 -R storage/
php artisan sync:data (запускает импорт данных)
```


если запуск идет через докер ,данная команда укажит какой домен для сайта
```
make info
```

