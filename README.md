Тестовое задание Xsolla
=======================

HTTP API для работы пользователей с файловой системой

 - [Требования](#Требования)
 - [Установка](#Установка)
 - [Docker](#docker)
 - [API Документация](#http-api)
 - [Демо](https://xsolla.antkaz.ru/) Параметры учетных записей для авторизации:
	 - Пользователь 1 **xsolla**
	 - Пароль: **123456789**
	 - Пользователь 2 **test**
	 - Пароль: **123456789**

Требования
----------

Для работы приложения ваш Web сервер должен поддерживать PHP 7.1

Установка
---------------

Для установки приложения необходимо выполнить следующие действия:

1. Клонировать репозиторий

    ```sh
    $ git clone https://github.com/yiisoft/yii2-app-basic.git path/to/project
    ```

2. Перейти в каталог с проектом

    ```sh
    $ cd /path/to/project
    ```

3. Установить зависимости через composer

    ```sh
    $ composer global require "fxp/composer-asset-plugin:^1.2.0"
    $ composer install
    ```

4. Создать базу данных. В качестве параметров пользователя и имя базы данных можно взять из файла config/db.php:
    ```php
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=xsolla',
        'username' => 'xsolla',
        'password' => 'x7CLoWm5THFTMTVn',
        'charset' => 'utf8',
    ];
    ```

5. Применить миграцию для создания таблиц в базе данных

    ```sh
    $ php yii migrate
    ```

6. Настроить Web сервер для запуска приложения. Рекомендуемые параметры Web сервера см на [Install Yii2](http://www.yiiframework.com/doc-2.0/guide-start-installation.html)

Docker
----------
1. Скачайте образ [Docker](http://xsolla.antkaz.ru/xsolla.tar.gz)
2. Загрузите образ из архива:

	```sh
	$ docker load < xsolla.tar.gz
	```
3. Запустите образ:

	```sh
	$ docker run -itd -h $name --name $name -p 80:80 -p 443:443 xsolla:test
	```
	- $name -- имя хоста
	- -h $name -- назначаемый хост в контейнере
	- --name $name -- имя контейнера (docker ps --all, столбец NAMES)
	- -p 22:22 [-p NN:NN, ...] -- проброс портов с хоста(22) в контейнер(22)
	- xsolla:test -- имя образа 
4. Выполните команды для запуска Web-сервера и сервера базы данных

	```sh
	$ docker exec -it $name /etc/init.d/apache2 start
	$ docker exec -it $name /etc/init.d/mysql start
	```

HTTP API
--------
### Стандартные ошибки API
| Код | Описание|
|---|---|
|200|Запрос отработан должным образом|
|201|Ресурс успешно создан в ответ на POST запрос|
|204|Запрос успешно обработан. Возвращает пустой ответ (предпочтительно для DELETE запросов)|
|304|Ресурс не был изменен|
|400|Плохой запрос. Может быть вызвана не корректными данными в запросе|
|401|Ошибка аутентификации|
|403|Ошибка авторизации. Доступ к ресурсу или действию для текущего пользователя запрещен|
|404|Запрашиваемый ресурс не найден|
|405|Метод не разрешен|
|415|Неподдерживаемый тип носителя. Недопустимый запрашиваемый тип содержимого или номер версии|
|422|Ошибка верификации данных. В ответе содержится сообщение с описанием ошибки|
|429|Превышен лимит запросов превышен|
|500|Ошибка сервера|

### Получение токена авторизации
#### /auth
Получить Token авторизации. Необходим для работы с файловой системой пользователя.

**Метод**: POST

**Параметры**
* *username* - имя пользователя
* *password* - пароль

**Возвращает**

Возвращает Token авторизации.
* *username* - имя пользователя, запрасивший токен;
* *access_token* - токен авторизации.

Пример ответа:
```
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    "username": "xsolla",
    "access_token": "xXu1vfjzscQDucuxFbT1d1tkYW9zMvrt"
}
```

### Работа с файловой системой
Для работы со следующими методами необходмо передать Token в заголовке запроса.
```
Authorization: Bearer {access_token}
```

#### /files (GET)
Получить список файлов пользователя

**Метод**: GET

**Параметры**
* *page* - номер страницы. Используется в том случае, если заголовок `X-Pagination-Page-Count` > 1

**Возвращает**

Возвращает список файлов пользователя в качестве массива. Каждый объект содержит:
* *file_id* - уникальный идентификатор файла;
* *filename* - имя файла. 

Пример ответа:
```
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
Link: {project-url}/files?page=1>; rel=self
X-Pagination-Current-Page: 1
X-Pagination-Page-Count: 1
X-Pagination-Per-Page: 10
X-Pagination-Total-Count: 3
X-Rate-Limit-Limit: 10
X-Rate-Limit-Remaining: 9
X-Rate-Limit-Reset: 0
...
[
    {
        "file_id": 1,
        "filename": "test.txt"
    },
    {
        "file_id": 2,
        "filename": "test2.txt"
    },
    {
        "file_id": 3,
        "filename": "test3.txt"
    }
]
```

#### /files (POST)
Создает новый файл и записывает в него данные из запроса.

**Метод** :POST

**Параметры**
* *filename* - имя файла
* *text* - текст, записываемые в файл

**Возвращает**

Возвращает параметры созданного файла. 
* *file_id* - уникальный идентификатор файла;
* *filename* - имя файла. 

Пример ответа:
```
HTTP/1.1 201 Created
Content-Type: application/json; charset=UTF-8
...
{
    "file_id": 3,
    "filename": "test3.txt"
}
```

#### /files/<file_id> (GET)
Выводит информацию о файле

**Метод**: GET

**Возвращает**

Возвращает данные запрашиваемого файла. 
* *file_id* - уникальный идентификатор файла;
* *filename* - имя файла;
* *text* - содержимое файла.
 
Пример ответа:
```
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    "file_id": 1,
    "filename": "file.txt",
    "text": "new text"
}
```

#### /files/<file_id> (PUT)
Обвноляет содержимое файла из данных в запросе

**Метод**: PUT

**Параметры**
* *text* - текст, который необходимо перезаписать в файл

**Возвращает**

Возвращает параметры файла, который был изменен. 
* *file_id* - уникальный идентификатор файла;
* *filename* - имя файла;

Пример ответа:
```
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    "file_id": 1,
    "filename": "file.txt"
}
```

#### /files/<file_id> (DELETE)
Удаляет файл пользователя из файловой системы

**Метод**: DELETE

**Ответ**

Возвращает пустой ответ, в случае успешного удаления. Пример ответа:
```
HTTP/1.1 204 No Content
Content-Type: application/json; charset=UTF-8
...
```

#### /files/<file_id>/meta (GET)
Выводит информацию о метаданных файла

**Метод**: GET

**Ответ**

Возвращает метаданные запрашиваемого файла. 
* *name* - имя файла;
* *size* - размер файла (в байтах);
* *updated* - дата последнего изменения;
* *mime_type* - MIME-тип файла;
* *md5_hash* - MD5 хэш файла.

Пример ответа:
```
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    "name": "file.txt",
    "size": 8,
    "updated": "27.06.2017 06:08:52",
    "mime_type": "text/plain; charset=us-ascii",
    "md5_hash": "f39092e2b663fef60bc0097fe914066e"
}
```
