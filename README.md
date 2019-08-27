<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project</h1>
    <br>
</p>

SET UP PROJECT
-------------------

```
composer install
php init
    directory for front site  - frontend/web
        now all work here
    directory for admin panel - backend/web
yii migrate

```

Коротко о результатах:
1. Регистрация – страница, на основе Active Record, имеющая три поля (Имя, Email, Пароль, Аватарка), капчу (встроенную в Yii) и кнопку «Отправить»
2. Пользователи – страница, которая выводит всех пользователей в виде таблицы
3.  для авторизированных пользователей сделать функционал общения между собой, т.е. любой авторизированный пользователь может отправить письмо любому (кроме себя) пользователю из списка