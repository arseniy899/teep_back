<?
require('include.php');

$id = IO::getInt("id");
if($id == 0)
	exit(IO::genErr(1));
$event = new Event($id);
$event->load_admin();
$event->load_checked_users();
 
$now = gmdate("D, d M Y H:i:s");
$filename = "data_export_" . date("Y-m-d") . ".csv";
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
header("Last-Modified: {$now} GMT");

// force download  
header("Content-Type: application/force-download; charset=utf-8");
header("Content-Type: application/octet-stream; charset=utf-8");
header("Content-Type: application/download; charset=utf-8");

// disposition / encoding on response body
header("Content-Disposition: attachment;filename={$filename}");
header("Content-Transfer-Encoding: binary");

$array = $event->users;
if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);