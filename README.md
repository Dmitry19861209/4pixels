# 4pixels
### Тестовое задание. Дмитрий Держаев

##### Скачать/клонировать/распаковать архив.

Установить библиотеки/пакеты:
```sh
composer install
```

Сгерерировать ключ
```sh
php artisan key:generate
```

Настроить подключение к БД в файле .env

```sh
DB_DATABASE=имя_базы
DB_USERNAME=логин
DB_PASSWORD=пароль
```

Запустить миграцию и сиды:

```sh
php artisan migrate --seed
```

Storage link:

```sh
php artisan storage:link
```

Прогнать тесты:
```sh
vendor/bin/phpunit tests/4pixels/SomeTest.php
```

Запуск приложения:
```sh
php artisan serve
```
