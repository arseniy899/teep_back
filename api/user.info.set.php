<?
require('include.php');
$login = IO::getString('login');
$mail = IO::getString('mail');
$name = IO::getString('name');
$instID = IO::getString('instID');
$USER_OBJ->email = $mail;
$USER_OBJ->name = $name;
$USER_OBJ->instituteID = $instID;
echo $USER_OBJ->saveInfoToBD();
