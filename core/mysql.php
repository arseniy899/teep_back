<?

//$db = mysqli_connect($CONFIG['DB']['host'],$CONFIG['DB']['login'],$CONFIG['DB']['password'],$CONFIG['DB']['dbname']);
//$db->set_charset($CONFIG['DB']['charset']);
$dbms = 'mysql';
$dsn = "$dbms:host={$CONFIG['DB']['host']};dbname={$CONFIG['DB']['dbname']};charset={$CONFIG['DB']['charset']}";

$db=new PDO($dsn, $CONFIG['DB']['login'], $CONFIG['DB']['password']);