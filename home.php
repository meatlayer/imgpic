<?
if(!defined("INDEX")) die('� �� ������� �� �� �����?');
$title="��������� ��������, ����";
ini_set("memory_limit", "256M");
if (isset($_COOKIE[image])) {
setcookie ("image", ""); }
// ������� :)
if (!empty($_REQUEST['quality'])) {
$qual = $_REQUEST['quality']; }
if (!empty($_REQUEST['resize'])) {
$res = $_REQUEST['resize']; } 
if (!empty($_FILES['imgs'])) {
 // �������� ���� ����������
    $imgs = $_FILES['imgs'];
    $imgs_size = $_FILES['imgs']['size'];
    $imgs_type = $_FILES['imgs']['type'];
    $imgs_name = $_FILES['imgs']['name'];
    $imgs_tmp_name = $_FILES['imgs']['tmp_name'];
 // ������ ������������ ��� ��������, ���� ��������, �� ������� ������
if ($imgs_size > 3*1024*1024) die 
(' <div style="text-align:left; width:888px">
<div id="rounded-box-5">
		<b class="r5"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b><b class="r1"></b>
		<div class="inner-box">
			<h3>��� �������� :(</h3>
			<p>������ ����� �������� ����� 3 ��.<br>
			���������� ����� �� ����������� �����������, ���� ����� ����� 3 000 000 ������.
			��������� ���� ������ ����������, �.� ���� ������� �� ���������.
			�� ������ ��������������� <a href="?to=resize" target="_blank"><u>����� ��������</u></a> ��� ��������� ���� � ������� ������ �����������.
			�� ��� ������� �������������� ����������� ������� ���������� �����������, ���� � ��� Windows xp/7/8 (����/�����������/Paint).
			<br>
			<p align="right"><a href="./"><b>����������� ��� ���</b></a> | <a href="?to=support"><b>��������� � ����</b></a></p></p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
 // �������� ���������� ������ ��� ��������
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
			<h3>��������� ������ :(</h3>
			<p>����������� �����: <strong>jpg, jpeg, png, gif</strong> �� 3��<br>
			���� � ���, ��� �� ������� ������ �������� � ���������� ������� �����������.
			� �������� ����������� ������ ����������� ����� - �����������.<br>
			<p align="right"><a href="./"><b>����������� ��� ���</b></a> | <a href="?to=support"><b>��������� � ����</b></a></p></p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
			
        }

 // �������� �������
            $img_size = getimagesize($imgs_tmp_name);
            $width_original = $img_size[0];
            $height_original = $img_size[1];
 // �������� �� �������, � ������ ���� ������� ����� �������� - ������
if ($width_original < $width_max || $height_original < $height_max) 

die (' <div style="text-align:left; width:888px">
<div id="rounded-box-5">
		<b class="r5"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b><b class="r1"></b>
		<div class="inner-box">
			<h3>��������� ������</h3>
			<p>��������� ��������� �������� � ��������� ������ '.$width_max.'x'.$height_max.'<br>���, ��� ����� ��� ������ :(
			<br>
			<p align="right"><a href="./"><b>����������� ��� ���</b></a> | <a href="?to=support"><b>��������� � ����</b></a></p>
			</p>
		</div>
		<b class="r1"></b><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r5"></b>
	</div></div>
 ');
 // ������ �������� �� ��������� ������� ������ ����������� ����� ���������� F5
if (isset($_COOKIE[image])) {
setcookie ("image", "");
header ("location: ./");
exit();
}
   if($imgs_type=="image/jpeg"){$image = imagecreatefromjpeg($imgs_tmp_name);}
   if($imgs_type=="image/png"){$image = imagecreatefrompng($imgs_tmp_name);}
   if($imgs_type=="image/gif"){$image = imagecreatefromgif($imgs_tmp_name);}
   
   if(isset($res)) {

    // ���������� ��������� 
       $ratio = $width_original/$res; 
       $w_dest = round($width_original/$ratio); 
       $h_dest = round($height_original/$ratio); 

       // ������ ������ �������� 
       $image_p = imagecreatetruecolor($w_dest,$h_dest); 
       imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w_dest, $h_dest, $width_original, $height_original);
	      } 
else {
// �������� ������ ����������� � ������� ��� ���������
$image_p = imagecreatetruecolor($width_original, $height_original);
 // ���������� ������� :)
 $image_p_1 = imagecreatetruecolor($width_original, $height_original);
// �������� ����������� � ���������� ����� ��������, �.�. � ������� GD ���������� ������� � �������� �������������� ������� ����������� �����
 imagecopyresized($image_p_1, $image, 0, 0, 0, 0, $width_original, $height_original, $width_original, $height_original);
 imagecopyresized($image_p, $image_p_1, 0, 0, 0, 0, $width_original, $height_original, $width_original, $height_original);
}
       
// ���������� ����� ��� �������� ��������
  $time = time();
// ��������� �������
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

// ������ ��� ����������
$ska = rnd(2);

// ���������� ���� �� �������� � �� �������� � �������� ��� ���
  $imgs_path = "x/".$time.$random.$ska.$rand.".jpg";
if (imagejpeg($image_p, $imgs_path, $qual)) {
$complete = "...";
if ($complete) {
echo "<div align=\"center\"><br>(<a href=\"./\"><b>��������� ���</b></a>)&nbsp;&nbsp;<a href=\"#link\"><span style=\"border-bottom:1px dotted;\">������</span> &#8595;</a><br><br><img src=\"$imgs_path\" style=\"max-width:99%\" alt=\"��������...\">\n</div>";
echo ' <br>
<div align="center" style="text-align:left; padding:9px; margin:5px; border:1px dashed; border-color:#A7A7A7; width:640px;">
<span style="font:17px Arial;"><a name="link"><strong>��� ������ �� ��� �����������</a> &radic;</strong></span><br>
������ ������:<br>
<input value="http://'.$domen.'/'.$imgs_path.'" type="text" size="64"><br><br>
BB-��� ��� ������:<br>
<input value="[img]http://'.$domen.'/'.$imgs_path.'[/img]" type="text" size="64"><br><br>
HTML-��� ��� �����:<br>
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
// ��������� ��������, ���� �������� �� ���� �� ���������, �� ������
            else {
                echo "<br><br><br><font color=red>������. �������� �� ���������!</font> | <a href=\"?to=support\"><b>��������� � ����</b></a><br><br><br>";
                unlink($imgs_path);
                //unlink($thumb_path);
                }
            }
    // ����� ������ ��� �����������
        else print ("<br><br><br><font color=red>������! ���-�� ����� �����... �������� ��� �� ����. | <a href=\"?to=support\"><b>��������� � ����</b></a></font>");
    }
    else {
    // ����� ��� �������� ��������
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
<font color=\"black\"><strong>������� ���� ��� ��������:</strong></font>
<br><input style=\"font:17px Verdana; color:gray;\" name=\"imgs\" type=\"file\" title=\"������� �� ���������\" size=\"35\"><br>
<span>
��������� ���������: <b>jpg, jpeg, png, gif</b> ����� ����� �� 3��.
</span>
<br>
<table border=\"0\"><tr><td>
��������:</td><td><input type=\"text\" size=\"5\" name=\"quality\" value=\"80\"> %</td>
<tr><td>
������ (<a style=\"cursor:pointer;\" onclick=\"alert('�� ������ ������� ���������� ������, ���� ������ ����� ������� ��� ������ ������������ �����������. ����� ��������� ������� ������������ �� ������, ��������� ����������� ��� ���� ����������� �������������!');\"><b>?</b></a>)</td><td>
<select name=\"resize\">
    <option value=\"\">��������</option>
	<option value=\"160\">160px</option>
	<option value=\"320\">320px</option>
    <option value=\"640\">640px</option>
    <option value=\"800\">800px</option>
    <option value=\"1024\">1024px</option>
</select></td></tr>
<tr><td>� ��������:</td><td><a href=\"?to=ok\"><u>����������</u></a></td></tr>
</table>
<br>
\n ";
echo "<span title=\"�������� ����, �� ��� ����� ������������ � ���������������� �����������!\"><input type=\"submit\" name=\"submit\" style=\"font:14px Verdana;\" value=\"  ��������� �����������  \"></span>\n";
echo "</form>\n";

echo " 
		</div>
		<b class=\"r1\"></b><b class=\"r1\"></b><b class=\"r1\"></b><b class=\"r2\"></b><b class=\"r2\"></b><b class=\"r3\"></b><b class=\"r4\"></b><b class=\"r5\"></b><b class=\"r7\"></b><b class=\"r10\"></b>
	</div></div>\n
	";

echo " 
<p class=\"infa\">������ ".$domen." ��������� ��� ������ � � ��������� ������� ���� �����������, ��������, ����.<br>
��� ���� ����� ��������� ���� ��������, ���� ��� ������� ����������� �����������, ������� �� ������ ������.
�������� ���� ����������� ���� �� ���������, �����, ������� �� ������ ���������� �����������. � ������� ���������� ������ ���� ����������� ����� ��������� � �� �������� ������ ������ �� ����, � ��� �� ������� ������ ��� �������, ������.
</p>
 ";}
?>