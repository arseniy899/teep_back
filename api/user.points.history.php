<?
require('include.php');
$data = [
 'rows'  => $USER_OBJ->getScoreHsitory()
];
echo IO::showJSres($data );
