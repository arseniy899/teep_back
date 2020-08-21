<?
require('include.php');
$data = [
 'inst'  => Misc::getInstitutes()
];
echo IO::showJSres($data);
