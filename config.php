<?php
 // ���������� ���� � ����� � ������
$myhome="/home/user123/imgpic.ru/";
 // ����� ����� ��� http � www
$domen="imgpic.ru";
 // ����������� ������ �������� 100x100px
$width_max = 100;
$height_max = 100;
 // �������� ���� ��� �������� �����
$mailto = "mail@imgpic.ru";
 // ����� ���������
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }
$time_start = getmicrotime();
?>