<?
if(!defined("INDEX")) die('� �� ������� �� �� �����?');
session_start();
$title="��������";
include('kcaptcha/kcaptcha.php');
$charset = "windows-1251";
$subject = $_POST['posRegard'];
$content = "text/plain";
$message = $_POST['posText'];
$statusError = "";
$statusSuccess = "";
$errors_name = '������� ���� ���';
$errors_mailfrom = '������� ���� E-mail �����';
$errors_incorrect = '��������� ��������� ��� E-mail �����';
$errors_message = '�������� ����� ������ ���������';
$errors_subject = '������� ���� ���������';
$captcha_error = '��������� ������������ ����� ��������� ����';
$send = '���� ��������� ������� ����������';
if ($_POST['act']== "y")
{
if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] ==  $_POST['keystring'])
{

if (isset($_POST['posName']) && $_POST['posName'] == "")
{
$statusError = "$errors_name";
}
elseif (isset($_POST['posEmail']) && $_POST['posEmail'] == "")
{
$statusError = "$errors_mailfrom";
}
elseif(isset($_POST['posEmail']) && !preg_match("/^([a-z,._,0-9])+@([a-z,._,0-9])+(.([a-z])+)+$/", $_POST['posEmail']))
{
$statusError = "$errors_incorrect";

unset($_POST['posEmail']);
}
elseif (isset($_POST['posRegard']) && $_POST['posRegard'] == "")
{
$statusError = "$errors_subject";
}
elseif (isset($_POST['posText']) && $_POST['posText'] == "")
{
$statusError = "$errors_message";
}

elseif (!empty($_POST))
{
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: $content  charset=$charset\r\n";
$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
$headers .= "From: \"".$_POST['posName']."\" <".$_POST['posEmail'].">\r\n";
$headers .= "X-Mailer: My Send E-mail\r\n";

mail("$mailto","$subject","$message","$headers");

unset($name, $posText, $mailto, $subject, $posRegard, $message);

$statusSuccess = "$send";
}

}else{
$statusError = "$captcha_error";
unset($_SESSION['captcha_keystring']);
}
}
?>
<div align="left" style="text-align:left; width:640px;">
<h2>O�pa��a� c����</h2>
<p id="emailSuccess">
<strong style="color:green;"><?php echo "$statusSuccess" ?></strong>
</p>
<p id="emailError"><strong style="color:red;"><?php echo "$statusError" ?></strong></p>
<div id="contactFormArea">
<form action="" method="post" id="cForm">
<input type="hidden" name="act" value="y">
<fieldset>
<label for="posName"><b>���� ���:</b></label><br>
<input class="text" type="text" size="25" name="posName" id="posName"><br><br>
<label for="posEmail"><b>��� E-mail �����:</b></label><br>
<input class="text" type="text" size="25" name="posEmail" id="posEmail"><br><br>
<label for="posRegard"><b>���� ���������:</b></label><br>
<select  name="posRegard" id="posRegard">
<option value="����� ������ �� �������">����� ������ �� �������</option>
<option value="����������� �� �������">����������� �� �������</option>
<option value="������, ���, ���������">������, ���, ���������</option>
<option value="������ - imgpic.ru">������</option>
</select><br><br>
<label for="posText"><b>���������:</b></label><br>
<textarea cols="50" rows="10" name="posText" id="posText"></textarea><br><br>
<label for="posCaptcha"><b>������� ���</b>:</label><br><input class="text" type="text" size="14" name="keystring" id="keystring"><br><a href="?to=support"><img src="kcaptcha?<?php echo session_name()?>=<?php echo session_id()?>" border=0></a>
<br><br><label><center><input class="submit" type="submit" name="selfCC" id="selfCC" value="  ��������� ���������  "></center></label>
</fieldset>
</form>
</div>
<br><center><img src="/image/ququ.png" border="0" alt="contact"></center>
</div>