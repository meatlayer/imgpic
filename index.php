<?php
define("INDEX",1);
include("config.php");

register_shutdown_function("output");

function output() {
global $design,$title,$menu,$time_start,$to;
$index=ob_get_contents();
ob_end_clean();
$design=file_get_contents($_SERVER['DOCUMENT_ROOT']."/design.html");
$time_end=round((getmicrotime()-$time_start)*1000)/1000;
echo str_replace(array("%title%","%menu%","%index%","%time%"),array($title,$menu,$index,$time_end),$design);
}

ob_start();
require_once("menu.php");
$menu=ob_get_contents();
ob_clean();

$to=$_GET[to];
if(preg_match("/^[a-z-]+$/",$to) && $to!="index" && is_file("$to.php")) require_once("$to.php");
else require_once("home.php");
?>