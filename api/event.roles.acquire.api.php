<?
require('include.php');
$hash = IO::getString("lk");

//$ret = Event::role_acquire($hash);
$errCode = $ret[0];
$acqRes = $ret[1];
/*if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]))
{
	if($errCode != 0)
		IO::genErrMsg($errCode, $acqRes);
	else
	{
		$data = [
		 'roleName'  => $acqRes['roleName'],
		 'eventName'  => $acqRes['eventName']
		];
		echo IO::showJSres($data );
	}
}*/