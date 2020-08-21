<?
require('include.php');
$hash = IO::getString("hash");

$ret = Event::checkin($hash);
$errCode = $ret[0];
$acqRes = $ret[1];
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]))
{
	if($errCode != 0)
		IO::genErrMsg($errCode, $acqRes);
	else
	{
		echo IO::showJSres($ret );
	}
}