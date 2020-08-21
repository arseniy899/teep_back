<?
class Misc
{
	
 
	public static function generate_string($strength = 16) 
	{
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($permitted_chars);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}
	public static function getInstitutes()
	{
		global $db;
		$query=$db->prepare("CALL settings_get('inst')");
		if($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
				
	}
}