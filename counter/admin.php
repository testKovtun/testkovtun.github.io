<?php

Error_Reporting(E_ALL & ~E_NOTICE);

include('config.inc.php');

// удаляем данные за выбранный день при нажатии на ссылке "удалить"
if (isset($delete)) {
    $delete = addslashes($delete);
    $del = mysql_query("delete from kscount WHERE date='$delete'");
}
if ($del) {
    echo '<span style="color: #FF0000">Статистика за день ' . 
    stripslashes($delete);
    echo ' удалена</span><br /><br />';

// Если ничего не выбрано, то выводим статистику по cookie за сегодня
if (!isset($take)) $take = 'cookie';

// Если не выбрана дата, то ставим сегодняшнюю
if (!$date) $date = date("Y-m-d");

// выводим все даты на экран
$result = mysql_query("SELECT distinct date FROM kscount");
$num_results = mysql_num_rows($result);

// выводим навигацию по статистике
for ($i = 0; $i < $num_results; $i++) {
    $row = mysql_fetch_array($result);
    echo htmlspecialchars(stripslashes($row["date"]));
    echo ' - <a href=admin.php?delete=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>удалить</a><br />';
    echo '<a href=admin.php?take=cookie&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Cookie</a> | ';
    echo '<a href=admin.php?take=referer&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Referer</a> | ';
    echo '<a href=admin.php?take=screen&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Разрешение экрана</a> | ';
    echo '<a href=admin.php?take=java&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Java</a> | ';
    echo '<a href=admin.php?take=browser&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Браузер и ОС</a> | ';
    echo '<a href=admin.php?take=page&date=' . 
    htmlspecialchars(stripslashes($row["date"]));
    echo '>Страницы</a><br /><br />';
}

// выводим выбранную статистику
echo 'Статистика за день: <strong>' . $date . '</strong><br /><br />';

echo '<strong>';
if ($take=='cookie') echo 'Cookie:';
elseif ($take=='referer') echo 'Referer:';
elseif ($take=='screen') echo 'Разрешение экрана:';
elseif ($take=='java') echo 'Поддержка Java:';
elseif ($take=='browser') echo 'Браузер и ОС:';
elseif ($take=='page') echo 'Страницы:';
echo '</strong><br />';

$result2 = mysql_query("SELECT $take, COUNT(distinct usip) FROM kscount 
       WHERE date='$date' GROUP BY $take;");

$num_results2 = mysql_num_rows($result2);
for ($i = 0; $i<$num_results2; $i++) {
    $row = mysql_fetch_array($result2);

    if ($take=='browser') {
        // Определяем браузер (можете добавить свои)
        if (stristr($row["$take"], 'Opera9.10')) {
            echo 'Браузер Opera';
        }
        elseif (stristr($row["$take"], 'MSIE 6.0')) {
            echo 'Браузер Internet Explorer 6.0';
        }
        elseif (stristr($row["$take"], 'Netscape5.0')) {
            echo 'Браузер Mozilla Firefox 2.0';
        }

        // если браузер неизвестен, то выведем всю строку из базы данных
        // изучив строку вы сможете определить браузер и 
        // добавить его в список выше
        else echo htmlspecialchars(stripslashes($row["$take"]));

        // Определяем операционную систему
        if (stristr($row["$take"], 'Windows NT 5.1')) echo ' с ОС Windows XP';
        elseif (stristr($row["$take"], 'linux')) echo ' с ОС Linux';
    }

    // если ОС неизвестена, то также выведем всю строку из базы данных
    // определим по ней ОС и добавим в список выше
    else echo htmlspecialchars(stripslashes($row["$take"]));

    // выводим количество посетителей
    printf("&nbsp; &nbsp; %d посетителей.\n", $row[1]);
    echo '<br />';
}

?>