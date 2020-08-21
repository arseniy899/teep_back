<?
require('include.php');
$avatarID = IO::getString('avatarID');
if(strlen($avatarID) == 0)
	$avatarID = $USER_OBJ->avatarID;
$email = $USER_OBJ->email;
$login = $USER_OBJ->login;
$id = $USER_OBJ->id;
/*var_dump($USER_OBJ);
var_dump($avatarID);
exit();*/
if(strlen($avatarID) <= 1)
	$path = "https://api.kwelo.com/v1/media/identicon/" .  md5("{$email} {$id} {$login}") ."";
else
	$path = AVATARS_PATH."/{$avatarID}.jpg";
//echo $path;
header('Content-Type: image/png');
readfile($path);