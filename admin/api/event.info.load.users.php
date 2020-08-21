<?
require('include.php');

$id = IO::getInt("id");
if($id == 0)
	exit(IO::genErr(1));
$event = new Event($id);
$event->load_admin();
$event->load_checked_users();
$data = [
 'rows'  => $event->users
];
echo IO::showJSres($data );
