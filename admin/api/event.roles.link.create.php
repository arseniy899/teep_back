<?
require('include.php');

$id = IO::getInt("id");
$role= IO::getInt("role");
if($id == 0 || $role == 0)
	exit(IO::genErr(1));
$event = new Event($id);
$link = $event->link_create($role);
$data = [
 'link'  => $link
];
echo IO::showJSres($data );
