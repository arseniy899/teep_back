<?
if(!defined('NO_ACC_CHECK'))
{
	if(!IS_USER_AUTHED)
	{
		if(!strstr(REQUESTED_PATH,"api") && !strstr(REQUESTED_FILE,"auth"))
		{
			$_SESSION['redir'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			header("Location: //".REMOTE_ROOT."/auth.php");
			exit();
		}
		else if(strstr(REQUESTED_PATH,"api") && !strstr(REQUESTED_PATH,"auth"))
			exit(IO::genErr(1000));
	}
	else if(strstr(REQUESTED_PATH,"/auth.php"))
	{
		if(isset($_SESSION['redir']))
			header("Location: ".$_SESSION['redir']);
		else
			header("Location: //". REMOTE_ROOT."/index.php");
		exit();
	}
	if( !IS_USER_ADMIN && strstr(realpath(NULL), "admin") )
	{
		header("Location: //". REMOTE_ROOT);
		exit();
	}
}