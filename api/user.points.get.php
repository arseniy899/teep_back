<?
require('include.php');
$data = [
 'points'  => $USER_OBJ->getScore()
];
echo IO::showJSres($data );
