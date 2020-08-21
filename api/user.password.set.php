<?
require('include.php');
$pwdNow = IO::getString('passw');
$pwdNew1 = IO::getString('passw_new');
$pwdNew2 = IO::getString('passw_new_re');
if($pwdNew1 != $pwdNew2)
	echo IO::genErr(1003);
//else if(User::cryptPass($pwdNow) != $USER_OBJ->password)
//	echo IO::genErr(1002);
else
{
	$USER_OBJ->password = User::cryptPass($pwdNew1);
	echo $USER_OBJ->saveInfoToBD();
}