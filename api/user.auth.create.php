<?
require ("include.php");
$login = IO::getString('login');
$name = IO::getString('name');
$mail = IO::getString('mail');
$password = IO::getString('passw');
$repass = IO::getString('repass');
$instID = IO::getString('instID');
echo DefErrors::showJSres(User::create($login, $name, $mail, $password, $repass, $instID));
