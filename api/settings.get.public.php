<?
define('NO_ACC_CHECK',true); //DANGEROUS! CHECK, IF all of data can be publically accessed! ------------------
require('include.php');
$data = [
 'inst'  => Misc::getInstitutes()
];
echo IO::showJSres($data);
