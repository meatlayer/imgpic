<?
if(!defined("INDEX")) die('А не пидарок ли ты часом?');
echo "<div align=\"center\" style=\"width:500px; text-align:left;\">Не малый выбор аватаров согласитесь? Хорошо, а как же сохранить для себя понравившийся аватар? Всё очень просто дорогие друзья. Нажмите на аватар, который вам понравился, правой кнопкой своей мыши и сохраните его на вашем комьютере.</div><br>";
$p=(int)$_GET[p];
$per=50;
$i=0; 
$n=0;
$dir="av/"; 
if ($handle = opendir($dir))
{
    while (false !== ($file = readdir($handle))) if ($file != "." && $file != "..")
    {
$n++; 
if($n>$p*$per && $n<=($p+1)*$per) {
      echo "<img border='0' src='".$dir.$file."' width='100' height='100'>\n";
      $i++; if($i >= 5) {echo "\n<br>\n"; $i=0;}
}
    }

    closedir($handle);
}

$pages=ceil($n/$per);
echo "<br>Страницы:<span class=\"nav\">";
for($i=0;$i<$pages;$i++) if($i==$p) echo "<b>(".($i+1).")</b>"; else echo "<a href=\"?to=avatar&p=$i\">".($i+1)."</a>";
echo "</span>";
if($pages > 2) {$title="Аватары. Cтраница:".($p+1);}
else { 
$title="Аватары"; }
?>