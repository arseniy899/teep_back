<?
require('include.php');

$id = IO::getInt("id");
if($id == 0)
	exit(IO::genErr(1));
$event = new Event($id);
$event->load_roles_links();

$data = [
 'rows'  => $event->rolesLinks
];
echo IO::showJSres($data );
