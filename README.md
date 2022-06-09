# Первый запуск проекта

1. Запустить проект:
```bash
docker-compose up --build
```

2. Установить зависимости:
```bash
docker-compose exec php-fpm composer install
```

3. Наполнить базу данных информацией:
```bash
docker-compose exec php-fpm bin/console app:up:db
```

4. Создать папку для блокировки:
```bash
docker-compose exec php-fpm mkdir /var/stores
docker-compose exec php-fpm chmod 777 /var/stores
```

# Запуск автотестов

```bash
docker-compose exec php-fpm bin/phpunit
```

