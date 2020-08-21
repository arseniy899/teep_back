<?

class IO
{
	public static function getInt($name)
	{
		if(isset($_GET[$name]))
			return $_GET[$name];
		else if(!isset($_POST[$name]))
			return 0;
		else
			return $_POST[$name];
	}
	public static function getString($name)
	{
		if(isset($_GET[$name]))
			return $_GET[$name];
		else if(!isset($_POST[$name]) && @$_POST[$name] != "0")
			return '';
		else
			return $_POST[$name];
	}
	
	public static function utf8ize($d) {
		if (is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = IO::utf8ize($v);
			}
		} else if (is_string ($d)) {
			//echo mb_detect_encoding($d);
			//return $d;
			return iconv(mb_detect_encoding($d, mb_detect_order(), true), "UTF-8", $d);
			//return mb_convert_encoding($d, 'UTF-8', 'Windows-1251');
		}
		return $d;
	}
    public static function genErr($id)
    {
        if(array_key_exists(strval($id),DefErrors::$errorsRU))
            $desc = DefErrors::$errorsRU[$id];
        else
            $desc="";
        $res = array();
		$res['responce']['error'] = $id;
		$res['responce']['desc'] = IO::utf8ize($desc);
		$json = json_encode($res,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		exit($json);
        
    }
	
	public static function showJSres($arr)
    {
		$res = array();
		$res['responce']['error'] = 0;
		$res['responce']['data'] = IO::utf8ize($arr);
		$json = json_encode($res,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		return $json;
    }
	public static function genErrMsg($id, $mess)
    {
        if(array_key_exists(strval($id),DefErrors::$errorsRU))
            $desc = DefErrors::$errorsRU[$id];
        else
            $desc="";
		$res = array();
		
		$res['responce']['error'] = $id;
		$res['responce']['message'] = IO::utf8ize($mess);
		$res['responce']['desc'] = IO::utf8ize($desc);
		
		$js = json_encode( $res,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		//echo $js;
		exit($js);
        
    }
	public static function getErrText($id)
    {
        if(array_key_exists(strval($id),DefErrors::$errorsRU))
            $desc = DefErrors::$errorsRU[$id];
        else
            $desc="";
		return $desc;
        
    }
	public static function printJsonRes($res)
	{
		global $db;
		if(!$res)exit(IO::genErr(3));
		if(mysqli_error($db) != null)
			IO::genErrMsg(3, "MySQL:".mysqli_error($db));
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$rows[] = $r;
		}
		echo IO::showJSres($rows);
	}
	public static function isQueryOK($result)
	{
		if(gettype($result)=='boolean'){ // test for boolean
			if($result)  // returned TRUE, e.g. in case of a DELETE sql  
				return true;
			else // returned FALSE
				return false;
			 
		} else { // must be a resource
				return mysqli_num_rows($result);
			//mysqli_free_result($result);  
		 }
	}
	public static function executeSqlParse($sql)
	{
		global $db;
		$query=$db->prepare($sql);
		if($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
		
	}
}