<?
if(!defined("INDEX")) die('А не пидарок ли ты часом?');
$title="загрузить картинку, фото";
ini_set("memory_limit", "256M");
if (isset($_COOKIE[image])) {
setcookie ("image", ""); }
// поехали :)
if (!empty($_REQUEST['quality'])) {
$qual = $_REQUEST['quality']; }
if (!empty($_REQUEST['resize'])) {
$res = $_REQUEST['resize']; } 
if (!empty($_FILES['imgs'])) {
 // назначим наши переменные
    $imgs = $_FILES['imgs'];
    $imgs_size = $_FILES['imgs']['size'];
    $imgs_type = $_FILES['imgs']['type'];
    $imgs_name = $_FILES['imgs']['name'];
    $imgs_tmp_name = $_FILES['imgs']['tmp_name'];
 // задаем максимальный вес картинки, если превышен, то выводим ошибку
if ($imgs_size > 3*1024*1024) die 
(' <div style="text-align:left; width:888px">
<div id="rounded-box-5">
		<b class="r5"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b><b class="r1"></b>
		<div class="inner-box">
			<h3>Вот незадача :(</h3>
			<p>Размер файла превысил лимит 3 МБ.<br>
			Установлен лимит на загружаемое изображение, этот лимит равен 3 000 000 байтам.
			Увеличить этот предел невозможно, т.к наши ресурсы не резиновые.
			Вы можете воспользоваться <a href="?to=resize" target="_blank"><u>нашим решением</u></a> для изменения веса и размера вашего изображения.
			Ну или наконец воспользуйтесь стандартным простым редактором изображений, если у вас Windows xp/7/8 (Пуск/Стандартные/Paint).
			<br>
			<p align="right"><a href="./"><b>Попробывать ещё раз</b></a> | <a href="?to=support"><b>Связаться с нами</b></a></p></p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
 // получаем расширения файлов для загрузки
    preg_match("'([a-z]+)\/[x\-]*([a-z]+)'", $imgs_type, $ext);
        switch($ext[2]) {
            case "jpg":
            case "jpeg":
            case "png":
			case "gif":
            break;
            default: die (' <div style="text-align:left; width:888px">
<div id="rounded-box-5">
		<b class="r5"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b><b class="r1"></b>
		<div class="inner-box">
			<h3>Произошла ошибка :(</h3>
			<p>Допускаются файлы: <strong>jpg, jpeg, png, gif</strong> до 3МБ<br>
			Дело в том, что мы выбрали только основные и популярные форматы изображений.
			К загрузке принимаются только графические файлы - изображения.<br>
			<p align="right"><a href="./"><b>Попробывать ещё раз</b></a> | <a href="?to=support"><b>Связаться с нами</b></a></p></p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
			
        }

 // получаем размеры
            $img_size = getimagesize($imgs_tmp_name);
            $width_original = $img_size[0];
            $height_original = $img_size[1];
 // проверка на размеры, в случае если размеры менее пределов - ошибка
if ($width_original < $width_max || $height_original < $height_max) 

die (' <div style="text-align:left; width:888px">
<div id="rounded-box-5">
		<b class="r5"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b><b class="r1"></b>
		<div class="inner-box">
			<h3>Произошла ошибка</h3>
			<p>Запрещено загружать картинки с размерами меньше '.$width_max.'x'.$height_max.'<br>Угу, вот такие вот пироги :(
			<br>
			<p align="right"><a href="./"><b>Попробывать ещё раз</b></a> | <a href="?to=support"><b>Связаться с нами</b></a></p>
			</p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
 // защита кукисами от повторной загузки одного изображения через обновление F5
if (isset($_COOKIE[image])) {
setcookie ("image", "");
header ("location: ./");
exit();
}
   if($imgs_type=="image/jpeg"){$image = imagecreatefromjpeg($imgs_tmp_name);}
   if($imgs_type=="image/png"){$image = imagecreatefrompng($imgs_tmp_name);}
   if($imgs_type=="image/gif"){$image = imagecreatefromgif($imgs_tmp_name);}
   
   if(isset($res)) {

    // вычисление пропорций 
       $ratio = $width_original/$res; 
       $w_dest = round($width_original/$ratio); 
       $h_dest = round($height_original/$ratio); 

       // создаём пустую картинку 
       $image_p = imagecreatetruecolor($w_dest,$h_dest); 
       imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w_dest, $h_dest, $width_original, $height_original);
	      } 
else {
// создадим пустое изображение с нужными нам размерами
$image_p = imagecreatetruecolor($width_original, $height_original);
 // собственно создали :)
 $image_p_1 = imagecreatetruecolor($width_original, $height_original);
// выполним копирование и ресамдлинг нашей картинки, т.е. с помощью GD библиотеки сгладим и заполним промежуточными цветами недостающие точки
 imagecopyresized($image_p_1, $image, 0, 0, 0, 0, $width_original, $height_original, $width_original, $height_original);
 imagecopyresized($image_p, $image_p_1, 0, 0, 0, 0, $width_original, $height_original, $width_original, $height_original);
}
       
// определяем время для названия картинки
  $time = time();
// генератор рандома
$random = mt_rand(0, 999);
$rand = mt_rand(0, 10);

function rnd($lenght=1){
	$y="";
	$x=array("a", "b", "c", "d");
	for( $i=0; $i<$lenght; $i++ ){
		$y.=$x[rand(0,count($x)-1)];
	}
	return $y;
}

// рандом для переменной
$ska = rnd(2);

// определяем пути до картинок и их миниатюр и названия для них
  $imgs_path = "x/".$time.$random.$ska.$rand.".jpg";
if (imagejpeg($image_p, $imgs_path, $qual)) {
$complete = "...";
if ($complete) {
echo "<div align=\"center\"><br>(<a href=\"./\"><b>Загрузить ещё</b></a>)&nbsp;&nbsp;<a href=\"#link\"><span style=\"border-bottom:1px dotted;\">Ссылки</span> &#8595;</a><br><br><img src=\"$imgs_path\" style=\"max-width:99%\" alt=\"Загрузка...\">\n</div>";
echo ' <br>
<div align="center" style="text-align:left; padding:9px; margin:5px; border:1px dashed; border-color:#A7A7A7; width:640px;">
<span style="font:17px Arial;"><a name="link"><strong>Все ссылки на это изображение</a> &radic;</strong></span><br>
Прямая ссылка:<br>
<input value="http://'.$domen.'/'.$imgs_path.'" type="text" size="64"><br><br>
BB-код для форума:<br>
<input value="[img]http://'.$domen.'/'.$imgs_path.'[/img]" type="text" size="64"><br><br>
HTML-код для сайта:<br>
<input value="&lt;img src=&quot;http://'.$domen.'/'.$imgs_path.'&quot; border=&quot;0&quot;&gt;" type="text" size="64">
<br><br>
</div>
 ';
@imagedestroy($image);
@imagedestroy($image_p);
@imagedestroy($image_p_1);
setcookie ("image", "1", time()+75);
exit();
 }
// очередная проверка, если картинка ни куда не добавлена, то ошибка
            else {
                echo "<br><br><br><font color=red>Ошибка. Картинка не загружена!</font> | <a href=\"?to=support\"><b>Связаться с нами</b></a><br><br><br>";
                unlink($imgs_path);
                //unlink($thumb_path);
                }
            }
    // вывод ошибки при копировании
        else print ("<br><br><br><font color=red>Ошибка! Что-то пошло нетак... Сообщите нам об этом. | <a href=\"?to=support\"><b>Связаться с нами</b></a></font>");
    }
    else {
    // форма для загрузки картинок
echo " <script>
function deleteCookie(name) { 
   var cookieDate = new Date(); 
   cookieDate.setTime(cookieDate.getTime() - 1); 
   document.cookie = (name + \"=; expires=\" + cookieDate.toGMTString()); 
} 
 </script>\n";
echo "<script> deleteCookie(\"image\"); </script>\n";
echo "<div id=\"upload\" align=\"center\">\n";
echo "
<div align=\"center\" id=\"rounded-box-10\">
		<b class=\"r10\"></b><b class=\"r7\"></b><b class=\"r5\"></b><b class=\"r4\"></b><b class=\"r3\"></b><b class=\"r2\"></b><b class=\"r2\"></b><b class=\"r1\"></b><b class=\"r1\"></b><b class=\"r1\"></b>
		<div class=\"inner-box\">
			 ";

echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
echo " 
<font color=\"black\"><strong>Выбрать файл для загрузки:</strong></font>
<br><input style=\"font:17px Verdana; color:gray;\" name=\"imgs\" type=\"file\" title=\"Выбрать на комьютере\" size=\"35\"><br>
<span>
Разрешено загружать: <b>jpg, jpeg, png, gif</b> файлы весом до 3МБ.
</span>
<br>
<table border=\"0\"><tr><td>
Качество:</td><td><input type=\"text\" size=\"5\" name=\"quality\" value=\"80\"> %</td>
<tr><td>
Размер (<a style=\"cursor:pointer;\" onclick=\"alert('Вы можете выбрать подходящий размер, этот размер будет применён для только загруженного изображения. Выбор изменения размера производится по ширине, пропорции изображения при этом вычисляются автоматически!');\"><b>?</b></a>)</td><td>
<select name=\"resize\">
    <option value=\"\">оригинал</option>
	<option value=\"160\">160px</option>
	<option value=\"320\">320px</option>
    <option value=\"640\">640px</option>
    <option value=\"800\">800px</option>
    <option value=\"1024\">1024px</option>
</select></td></tr>
<tr><td>Я принимаю:</td><td><a href=\"?to=ok\"><u>соглашение</u></a></td></tr>
</table>
<br>
\n ";
echo "<span title=\"Загружая файл, вы тем самом соглашаеетсь с пользовательским соглашением!\"><input type=\"submit\" name=\"submit\" style=\"font:14px Verdana;\" value=\"  Загрузить изображение  \"></span>\n";
echo "</form>\n";

echo " 
		</div>
		<b class=\"r1\"></b><b class=\"r1\"></b><b class=\"r1\"></b><b class=\"r2\"></b><b class=\"r2\"></b><b class=\"r3\"></b><b class=\"r4\"></b><b class=\"r5\"></b><b class=\"r7\"></b><b class=\"r10\"></b>
	</div></div>\n
	";

echo " 
<p class=\"infa\">Сервис ".$domen." позволяет вам просто и с удобством хранить свои изображения, картинки, фото.<br>
Для того чтобы загрузить вашу картинку, фото или обычное графическое изображение, нажмите на кнопку «Обзор».
Выберите свой графический файл на комьютере, после, нажмите на кнопку «Загрузить изображение». В течении нескольких секунд ваше изображение будет загружено и вы получите прямую ссылку на него, а так же готовые ссылки для форумов, сайтов.
</p>
 ";}
?>