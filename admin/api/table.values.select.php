<?php
require('include.php');
$table = IO::getString('m');
$data = array();

if(isset($table) && $table != "")
{
	$order = IO::getString('order');
	if( empty($order) )
		$sql = "SELECT * FROM `{$table}` LIMIT 1000";
	else
		$sql = "SELECT * FROM `{$table}` ORDER BY {$order} LIMIT 1000";
	$data['rows']=IO::executeSqlParse($sql);
}

echo IO::showJSres($data);