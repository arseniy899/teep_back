<?php
require('include.php');
$table = IO::getString('m');
if(!isset($table))
	$table = 'units_run';

$id = IO::getString('id');
$createNew = True;
if( isset($id) && $id != "")
{
	$sql = " DELETE FROM `{$table}` WHERE `id`={$id}";
	$query=$db->prepare($sql);
	if($query->execute())
	{
		$query->closeCursor();
		return (IO::genErr(0));
	}
	else
		return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
}
exit(DefErrors::genErr(3));