<?php
/* @var $this yii\web\View */

use yii\bootstrap\Nav;

$this->title = 'API Documentation';
?>
<div class="row">
    <div class="hidden-xs col-md-3">
        <div style="position: fixed">
            <?=
            Nav::widget([
                'options' => [
                    'class' => 'nav nav-pills nav-stacked',
                ],
                'items' => [
                    [
                        'label' => 'Стандартные ошибки API',
                        'url' => ['/doc#errors'],
                    ],
                    [
                        'label' => 'Получение токена авторизации',
                        'url' => ['/doc#token'],
                    ],
                    [
                        'label' => '/auth',
                        'url' => ['/doc#token'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => 'Работа с файловой системой',
                        'url' => ['/doc#api'],
                    ],
                    [
                        'label' => '/files (GET)',
                        'url' => ['/doc#list'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => '/files (POST)',
                        'url' => ['/doc#create'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => '/files/<file_id> (GET)',
                        'url' => ['/doc#view'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => '/files/<file_id> (PUT)',
                        'url' => ['/doc#update'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => '/files/<file_id> (DELETE)',
                        'url' => ['/doc#delete'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                    [
                        'label' => '/files/<file_id>/meta (GET)',
                        'url' => ['/doc#meta'],
                        'options' => [
                            'style' => 'margin-left: 20px;'
                        ]
                    ],
                ]
            ])
            ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-7">
        <h3 id="errors">Стандартные ошибки API</h3>

        <table class="table table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th>Код</th>
                    <th>Описание</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>200</td>
                    <td>Запрос отработан должным образом</td>
                </tr>
                <tr>
                    <td>201</td>
                    <td>Ресурс успешно создан в ответ на POST запрос</td>
                </tr>
                <tr>
                    <td>204</td>
                    <td>Запрос успешно обработан. Возвращает пустой ответ (предпочтительно для DELETE запросов)</td>
                </tr>
                <tr>
                    <td>304</td>
                    <td>Ресурс не был изменен</td>
                </tr>
                <tr>
                    <td>400</td>
                    <td>Плохой запрос. Может быть вызвана не корректными данными в запросе</td>
                </tr>
                <tr>
                    <td>401</td>
                    <td>Ошибка аутентификации</td>
                </tr>
                <tr>
                    <td>403</td>
                    <td>Ошибка авторизации. Доступ к ресурсу или действию для текущего пользователя запрещен</td>
                </tr>
                <tr>
                    <td>404</td>
                    <td>Запрашиваемый ресурс не найден</td>
                </tr>
                <tr>
                    <td>405</td>
                    <td>Метод не разрешен</td>
                </tr>
                <tr>
                    <td>415</td>
                    <td>Неподдерживаемый тип носителя. Недопустимый запрашиваемый тип содержимого или номер версии</td>
                </tr>
                <tr>
                    <td>422</td>
                    <td>Ошибка верификации данных. В ответе содержится сообщение с описанием ошибки</td>
                </tr>
                <tr>
                    <td>429</td>
                    <td>Превышен лимит запросов превышен</td>
                </tr>
                <tr>
                    <td>500</td>
                    <td>Ошибка сервера</td>
                </tr>
            </tbody>
        </table>

        <h3 id="token">Получение токена авторизации</h3>

        <h4>/auth</h4>

        <p>Получить Token авторизации. Необходим для работы с файловой системой пользователя.</p>

        <p><strong>Метод</strong>: POST</p>

        <p><strong>Параметры</strong></p>

        <ul>
            <li><em>username</em>&nbsp;- имя пользователя</li>
            <li><em>password</em>&nbsp;- пароль</li>
        </ul>

        <p><strong>Возвращает</strong></p>

        <p>Возвращает Token авторизации.</p>

        <ul>
            <li><em>username</em>&nbsp;- имя пользователя, запрасивший токен;</li>
            <li><em>access_token</em>&nbsp;- токен авторизации.</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    &quot;username&quot;: &quot;xsolla&quot;,
    &quot;access_token&quot;: &quot;xXu1vfjzscQDucuxFbT1d1tkYW9zMvrt&quot;
}
</code></pre>

        <h3 id="api">Работа с файловой системой</h3>

        <p>Для работы со следующими методами необходмо передать Token в заголовке запроса.</p>

        <pre>
<code>Authorization: Bearer {access_token}
</code></pre>

        <h4 id="list">/files (GET)</h4>

        <p>Получить список файлов пользователя</p>

        <p><strong>Метод</strong>: GET</p>

        <p><strong>Параметры</strong></p>

        <ul>
            <li><em>page</em>&nbsp;- номер страницы. Используется в том случае, если заголовок&nbsp;<code>X-Pagination-Page-Count</code>&nbsp;&gt; 1</li>
        </ul>

        <p><strong>Возвращает</strong></p>

        <p>Возвращает список файлов пользователя в качестве массива. Каждый объект содержит:</p>

        <ul>
            <li><em>file_id</em>&nbsp;- уникальный идентификатор файла;</li>
            <li><em>filename</em>&nbsp;- имя файла.</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
Link: {project-url}/files?page=1&gt;; rel=self
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
        &quot;file_id&quot;: 1,
        &quot;filename&quot;: &quot;test.txt&quot;
    },
    {
        &quot;file_id&quot;: 2,
        &quot;filename&quot;: &quot;test2.txt&quot;
    },
    {
        &quot;file_id&quot;: 3,
        &quot;filename&quot;: &quot;test3.txt&quot;
    }
]
</code></pre>

        <h4 id="create">/files (POST)</h4>

        <p>Создает новый файл и записывает в него данные из запроса.</p>

        <p><strong>Метод</strong>&nbsp;:POST</p>

        <p><strong>Параметры</strong></p>

        <ul>
            <li><em>filename</em>&nbsp;- имя файла</li>
            <li><em>text</em>&nbsp;- текст, записываемые в файл</li>
        </ul>

        <p><strong>Возвращает</strong></p>

        <p>Возвращает параметры созданного файла.</p>

        <ul>
            <li><em>file_id</em>&nbsp;- уникальный идентификатор файла;</li>
            <li><em>filename</em>&nbsp;- имя файла.</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 201 Created
Content-Type: application/json; charset=UTF-8
...
{
    &quot;file_id&quot;: 3,
    &quot;filename&quot;: &quot;test3.txt&quot;
}
</code></pre>

        <h4 id="view">/files/&lt;file_id&gt; (GET)</h4>

        <p>Выводит информацию о файле</p>

        <p><strong>Метод</strong>: GET</p>

        <p><strong>Возвращает</strong></p>

        <p>Возвращает данные запрашиваемого файла.</p>

        <ul>
            <li><em>file_id</em>&nbsp;- уникальный идентификатор файла;</li>
            <li><em>filename</em>&nbsp;- имя файла;</li>
            <li><em>text</em>&nbsp;- содержимое файла.</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    &quot;file_id&quot;: 1,
    &quot;filename&quot;: &quot;file.txt&quot;,
    &quot;text&quot;: &quot;new text&quot;
}
</code></pre>

        <h4 id="update">/files/&lt;file_id&gt; (PUT)</h4>

        <p>Обвноляет содержимое файла из данных в запросе</p>

        <p><strong>Метод</strong>: PUT</p>

        <p><strong>Параметры</strong></p>

        <ul>
            <li><em>text</em>&nbsp;- текст, который необходимо перезаписать в файл</li>
        </ul>

        <p><strong>Возвращает</strong></p>

        <p>Возвращает параметры файла, который был изменен.</p>

        <ul>
            <li><em>file_id</em>&nbsp;- уникальный идентификатор файла;</li>
            <li><em>filename</em>&nbsp;- имя файла;</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    &quot;file_id&quot;: 1,
    &quot;filename&quot;: &quot;file.txt&quot;
}
</code></pre>

        <h4 id="delete">/files/&lt;file_id&gt; (DELETE)</h4>

        <p>Удаляет файл пользователя из файловой системы</p>

        <p><strong>Метод</strong>: DELETE</p>

        <p><strong>Ответ</strong></p>

        <p>Возвращает пустой ответ, в случае успешного удаления. Пример ответа:</p>

        <pre>
<code>HTTP/1.1 204 No Content
Content-Type: application/json; charset=UTF-8
...
</code></pre>

        <h4 id="meta">/files/&lt;file_id&gt;/meta (GET)</h4>

        <p>Выводит информацию о метаданных файла</p>

        <p><strong>Метод</strong>: GET</p>

        <p><strong>Ответ</strong></p>

        <p>Возвращает метаданные запрашиваемого файла.</p>

        <ul>
            <li><em>name</em>&nbsp;- имя файла;</li>
            <li><em>size</em>&nbsp;- размер файла (в байтах);</li>
            <li><em>updated</em>&nbsp;- дата последнего изменения;</li>
            <li><em>mime_type</em>&nbsp;- MIME-тип файла;</li>
            <li><em>md5_hash</em>&nbsp;- MD5 хэш файла.</li>
        </ul>

        <p>Пример ответа:</p>

        <pre>
<code>HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
...
{
    &quot;name&quot;: &quot;file.txt&quot;,
    &quot;size&quot;: 8,
    &quot;updated&quot;: &quot;27.06.2017 06:08:52&quot;,
    &quot;mime_type&quot;: &quot;text/plain; charset=us-ascii&quot;,
    &quot;md5_hash&quot;: &quot;f39092e2b663fef60bc0097fe914066e&quot;
}
</code></pre>
    </div>
</div>