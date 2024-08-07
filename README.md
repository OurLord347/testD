## Установка и настройка



### Шаги по установке

1. Соберите и запустите контейнер:

bash
docker-compose up -d --build


2. Установите зависимости:


bash
composer install


3. Создайте базу данных и выполните миграции:


bash
php bin/console doctrine:migrations:migrate


## Использование

### API Endpoints

#### Создать гостя

- *URL:* /guests
- *Метод:* POST
- *Пример запроса:*


json
{
"first_name": "John",
"last_name": "Doe",
"email": "john.doe@example.com",
"phone": "+79171234567",
"country": "USA"
}


- *Ответ (201 Created):*


json
{
"id": "UUID",
"first_name": "John",
"last_name": "Doe",
"email": "john.doe@example.com",
"phone": "+79171234567",
"country": "USA"
}


#### Обновить гостя

- *URL:* /guests/{id}
- *Метод:* PUT
- *Пример запроса:*


json
{
"first_name": "Jane",
"last_name": "Doe",
"email": "jane.doe@example.com",
"phone": "+79171234567",
"country": "Canada"
}


- *Ответ (200 OK):*


json
{
"id": "UUID",
"first_name": "Jane",
"last_name": "Doe",
"email": "jane.doe@example.com",
"phone": "+79171234567",
"country": "Canada"
}


#### Получить информацию о госте

- *URL:* /guests/{id}
- *Метод:* GET
- *Пример запроса:* Не требуется тело запроса.
- *Ответ (200 OK):*


json
{
"id": "UUID",
"first_name": "Jane",
"last_name": "Doe",
"email": "jane.doe@example.com",
"phone": "+79171234567,
"country": "Canada"
}


#### Удалить гостя

- *URL:* /guests/{id}
- *Метод:* DELETE
- *Пример запроса:* Не требуется тело запроса.
- *Ответ (204 No Content):* Пустой ответ.

### Заголовки ответа

В каждом ответе будут присутствовать следующие заголовки:

- X-Debug-Time: Время выполнения запроса в миллисекундах.
- X-Debug-Memory: Память, использованная при выполнении запроса, в килобайтах.
