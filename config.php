<?php
 // абсолютный путь к папке с сайтом
$myhome="/home/user123/imgpic.ru/";
 // домен сайта без http и www
$domen="imgpic.ru";
 // минимальный размер картинки 100x100px
$width_max = 100;
$height_max = 100;
 // почтовый ящик для обратной связи
$mailto = "mail@imgpic.ru";
 // время генерации
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }
$time_start = getmicrotime();
?>