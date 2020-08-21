<?
error_reporting(E_ALL);
ini_set('display_errors', true);
session_name('Private'); 
session_start(); 

if(isset($_COOKIE["user"]))
{
	$_SESSION['user'] = unserialize(base64_decode($_COOKIE["user"]));
	if(isset($_COOKIE['admin']) && $_COOKIE['admin'] == true)
		$_SESSION['admin'] = true;
}

define('DOMAIN', $_SERVER["SERVER_NAME"]);
$suffix = "/teep_back";
define('INC_ROOT', DOMAIN.$suffix);
define('REMOTE_ROOT', INC_ROOT);
define('REMOTE_ROOT_PATH', "//".DOMAIN."/".$_SERVER["CONTEXT_PREFIX"]."/");
define('LOCAL_ROOT', rtrim($_SERVER["CONTEXT_DOCUMENT_ROOT"],"/").$suffix."/");
define('LOCAL_VER_ROOT', rtrim($_SERVER["CONTEXT_DOCUMENT_ROOT"],"/")."/");
define('REMOTE_PATH', $_SERVER['SCRIPT_NAME']);
define('REQUESTED_FILE', basename($_SERVER["REQUEST_URI"], ".php"));
define('REQUESTED_PATH', $_SERVER["REQUEST_URI"]);
define('IS_USER_AUTHED', isset($_SESSION['user']));
define('IS_USER_ADMIN', (isset($_SESSION['admin']) && $_SESSION['admin']!=0));

//paths
define('AVATARS_PATH', LOCAL_ROOT."upload/avatars");
define('ROLES_LINK_PATH', "http://".INC_ROOT."/event.roles.acquire.php?lk=");


if(IS_USER_AUTHED)
	$USER_OBJ = $_SESSION['user'];
