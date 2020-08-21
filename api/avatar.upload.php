<?
require('include.php');
//header('Content-Type: image/png');

if(isset($_FILES['avatar']))
{
	$file = $_FILES['avatar'];
	$errors= array();
	$file_name = $file['name'];
	$file_size =$file['size'];
	$file_tmp =$file['tmp_name'];
	$file_type=$file['type'];
	$file_ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false)
		echo IO::genErr(1005);
	else if($file_size > 2097152)
		echo IO::genErr(1006);
	else
	{
		$avatarID = Misc::generate_string();
		if($file_ext != "jpg")
			imagejpeg(imagecreatefromstring(file_get_contents($file["tmp_name"])), AVATARS_PATH."/{$avatarID}.jpg");
		else
		//define ('SITE_ROOT', realpath(dirname(__FILE__)));
			move_uploaded_file($file_tmp,AVATARS_PATH."/{$avatarID}.".$file_ext);
		echo $USER_OBJ->setAvatar($avatarID);
	}
	
}
else
	echo IO::genErr(1);
