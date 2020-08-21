<?php
require('include.php');
$table = IO::getString('m');
if(!isset($table))
	$table = 'units_run';

$id = IO::getString('id');
$createNew = True;
if( isset($id) && $id != "")
{
	$sql = "SELECT `id` FROM `{$table}` WHERE `id`={$id}";
	$query=$db->prepare($sql);
	if($query->execute())
	{
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$query->closeCursor();
		if(count($res) > 0)
			$createNew = False;
	}
	else
		return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
	
		
}
if(!$createNew)
{
	$pairs = [];
	foreach($_POST as $key => $value)
	{
		if(strlen($key)>0 && $key!="id" && $key!="edit")
		{
			$value = html_entity_decode($value);
			if($value == "<br />")
				$value = "";
			if($value == "<br>")
				$value = "";
			$value = str_replace("<br />","\\n",$value);
			$value = str_replace("<br>","\\n",$value);
			//$value = chop($value,"<br>");
			//$value = str_replace("'","\\'",$value);
			//$value = str_replace("\"","\\\"",$value);
			if($key == "password")
				$value = User::cryptPass($value);
			$pairs[] = "`{$key}`='{$value}'";
		}
	}
	$pairs_str = implode(',', $pairs);
	
	$sql = "UPDATE `{$table}` SET {$pairs_str} WHERE `id`='{$id}'";
	$query=$db->prepare($sql);
	if($query->execute())
	{
		$query->closeCursor();
		return (IO::genErr(0));
	}
	else
		return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
	
}
else
{
	$names = [];
	$values = [];
	foreach($_POST as $key => $value)
	{
		if($value == "<br />")
			$value = "";
		if($value == "<br>")
			$value = "";
		$value = str_replace("<br />","\\n",$value);
		$value = str_replace("<br>","\\n",$value);
		$value = chop($value,"<br>");
		if($key == "password")
			$value = User::cryptPass($value);
		if(strlen($key)>0 && strlen($value)>=1 && $key!="id" && $key!="edit")
		{
			$names[]= "`{$key}`";
			$values[]= html_entity_decode("'{$value}'")	;
		}
	}
	$columns = implode(", ",$names);
	
	$values  = implode(", ", $values);
	//$values = str_replace("'","\\'",$values);
	//$values = str_replace("\"","\\\"",$values);
	$sql = "INSERT INTO `{$_GET['m']}`({$columns}) VALUES ({$values})";
	$query=$db->prepare($sql);
	if($query->execute())
	{
		$query->closeCursor();
		return (IO::genErr(0));
	}
	else
		return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
	
}
