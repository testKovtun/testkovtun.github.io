<?php

define('DB_HOST', 'pages.github.com'); // сервер БД
define('DB_USER', 'login'); // логин БД
define('DB_PASS', 'password'); // пароль БД
define('DB_NAME', 'database'); // имя БД

if (!$conn = mysql_connect(DB_HOST,DB_USER,DB_PASS)) {
    echo 'не могу подключиться к серверу БД';
     exit();
}
if (!mysql_select_db(DB_NAME)) {
    echo 'не могу подключить БД';
     exit();
}

?>