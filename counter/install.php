<?php 

include('config.inc.php');

$result2 = mysql_query("create table countall (countall char(255) null); ");
$result3 = mysql_query("insert into countall values ('0')");
$result = mysql_query("create table kscount 
    (usip char(30) null, cookie char(10) null, 
    referer text null, screen char(30) null, 
    java char(10) null, browser char(255) null, 
    page char(255) null, date date null); ");

if ($result AND $result2 AND $result3) echo 'установка успешно завершена';
else echo 'не могу завершить установку';

?>