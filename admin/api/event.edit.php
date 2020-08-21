<?
require('include.php');
$id = IO::getInt("id");
$name = IO::getString("name");
$points = IO::getString("points");
$dtStart = IO::getString("dtStart");
$dtEnd = IO::getString("dtEnd");
if($id != 0)
{
	$event = new Event($id);
	$event->name = $name;
	$event->points = $points;
	$event->dtStart = $dtStart;
	$event->dtEnd = $dtEnd;
	$event->saveEdits();
}
else
{
	
	$event = Event::create($name, $points,$dtStart, $dtEnd);
}
echo IO::genErr(0);
