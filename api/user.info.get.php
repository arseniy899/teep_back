<?
require('include.php');
$data = [
 'events'  	=> $USER_OBJ->getScoreHsitory(),
 'name'  	=> $USER_OBJ->name,
 'login'  	=> $USER_OBJ->login,
 'email'  	=> $USER_OBJ->email,
 'avatarID' => $USER_OBJ->avatarID,
 'instID' 	=> $USER_OBJ->instituteID 
];
echo IO::showJSres($data );
