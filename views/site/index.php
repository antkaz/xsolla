<?php
/* @var $this yii\web\View */


$this->title = 'Xsolla';
?>

<h1 dir="ltr">HTTP API для работы с файловой системой</h1>
<h2 dir="ltr">Задача</h2>
<p dir="ltr">Требуется создать HTTP API для работы внешних пользователей с файловой системой на сервере.</p>
<h2 dir="ltr">Команды API</h2>
<ul>
    <li dir="ltr">
        <p dir="ltr">Создать файл из данных в запросе</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Обновить содержимое файла из данных в запросе</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Получить содержимое файла</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Получить метаданные файла</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Получить список файлов</p>
    </li>
</ul>
<h2 dir="ltr">Дополнительно</h2>
<ul>
    <li dir="ltr">
        <p dir="ltr">Поддержка вложенных директорий не требуется. Достаточно реализовать операции над файлами в одной директории.</p>
    </li>
</ul>
<h2 dir="ltr">Примеры</h2>
<ul>
    <li dir="ltr">
        <p dir="ltr">AWS S3 API <a href="http://docs.aws.amazon.com/AmazonS3/latest/API/APIRest.html">http://docs.aws.amazon.com/AmazonS3/latest/API/APIRest.html</a></p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Dropbox Core API <a href="https://www.dropbox.com/developers/core/docs">https://www.dropbox.com/developers/core/docs</a></p>
    </li>
</ul>
<h2 dir="ltr">Обязательные условия</h2>
<ul>
    <li dir="ltr">
        <p dir="ltr">Корректная обработка всех исключительных ситуаций и согласованный формат ошибок в ответах API</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Наличие тестов</p>
    </li>
</ul>
<h2 dir="ltr">Дополнительными плюсами будет:</h2>
<p dir="ltr">Можно реализовывать любое количество пунктов из списка ниже (даже ноль). Они разбиты по логическим блокам и друг от друга не зависят (даже внутри блока).</p>
<p dir="ltr">Если вы не успеваете сделать функционал, который хотите реализовать, можете добавить описание в readme:</p>
<ul>
    <li dir="ltr">
        <p dir="ltr">Какие подходы и технологии вы бы использовали</p>
    </li>
    <li dir="ltr">
        <p dir="ltr">Почему эту фичу важнее реализовать, чем другие</p>
    </li>
</ul>
<h2 dir="ltr">Список дополнительных фич</h2>
<ul>
    <li dir="ltr">
        <p dir="ltr">Работа с PHP экосистемой</p>

        <ul>
            <li dir="ltr">
                <p dir="ltr">Использование composer</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Использование сторонних библиотек и фреймворков</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Использование функционала последних версий php(5.5 - 7.0)</p>
            </li>
        </ul>
    </li>
    <li dir="ltr">
        <p dir="ltr">Оформление</p>

        <ul>
            <li dir="ltr">
                <p dir="ltr">README.md или документация(желательно на английском)</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Оформленный проект на Github</p>
            </li>
        </ul>
    </li>
    <li dir="ltr">
        <p dir="ltr">Оптимизация</p>

        <ul>
            <li dir="ltr">
                <p dir="ltr">Оптимизация загрузки и отдачи файлов(в первую очередь используемой памяти)</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Gzip сжатие ответов</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Поддержка gzip запросов</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Хранение файлов в сжатом виде</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">HTTP кэширование повторных вызовов получения данных</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Работа с оооочень большими файлами</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Разруливание конкурентного доступа к файлу</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Отдача фрагмента файла</p>
            </li>
        </ul>
    </li>
    <li dir="ltr">
        <p dir="ltr">Безопасность</p>

        <ul>
            <li dir="ltr">
                <p dir="ltr">Ограничение директории, доступной для записи</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Лимиты на размер загружаемых файлов</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Механизм авторизации в апи</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">HTTPS</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Ограничения на количество запросов к API для клиента и/или ip адреса</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Привязка файла к клиенту-создателю и запрет на изменение для других клиентов.</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Квоты с местом и лимит для пользователя</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">HTTP заголовки в ответах, для безопасного вызова API со сторонней веб-страницы в браузере</p>
            </li>
        </ul>
    </li>
    <li dir="ltr">
        <p dir="ltr">Окружение</p>

        <ul>
            <li dir="ltr">
                <p dir="ltr">Запуск из встроенного PHP сервера</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Настроенный Vagrant/Docker/Chef/Puppet с веб-сервером, PHP и приложением</p>
            </li>
        </ul>
    </li>
    <li dir="ltr">
        <p dir="ltr">Остальное</p>
        <ul>
            <li dir="ltr">
                <p dir="ltr">Правильный Content-Type в ответах</p>
            </li>
            <li dir="ltr">
                <p dir="ltr">Отдельный документ с описанием архитектуры подобного API, работающего с высокой нагрузкой(больше 100 запросов в секунду, терабайты данных)</p>
            </li>
        </ul>
    </li>
</ul>
