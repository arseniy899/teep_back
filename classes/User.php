<?

class User
{
	public $id = 0;
	public $login = '';
	public $email = '';
	public $name = '';
	public $avatarID = 0;
	public $points = 0;
	public $instituteID = 0;
	public $instituteName = '';
	public $password = '';
	public $isSetAble = False;
	public $isAdmin = False;
	function __construct($id, $login) 
	{
		$this->id = $id;
		$this->login = $login;
	}
	public static function cryptPass($password)
	{
		//return $password;
		return md5($password."bV8Pj4Vd");
	}
	public static function create($login, $name, $email, $password, $repass, $instituteID)
	{
		global $db;
		if(/*strlen($login) == 0 ||*/ strlen($name) == 0 || strlen($instituteID) == 0 || strlen($password) == 0 || strlen($repass) == 0)
			return IO::genErr(1);
		if( $password != $repass )
			return IO::genErr(1003);
		
		
		$query=$db->prepare('CALL user_create(:login, :name, :email, :password, :instituteID)');
		$query->bindValue(':login', 	$login, 	PDO::PARAM_STR);
		$query->bindValue(':password', 	User::cryptPass($password), 	PDO::PARAM_STR);
		$query->bindValue(':name', 		$name, 		PDO::PARAM_STR);
		$query->bindValue(':email', 	$email, 	PDO::PARAM_STR);
		$query->bindValue(':instituteID', 	$instituteID, 	PDO::PARAM_STR);
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			if($errcode == 0)
			{		
				 $query->closeCursor();
				USER::authLogin($login, $password);
				return IO::genErr(0);
			}
			else
				return IO::genErr($errcode);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
		
	}
	static function applyUserEdits($user)
	{
		global $USER_OBJ;
		$USER_OBJ = $user;
		$_SESSION['user'] = $USER_OBJ;
		setcookie("user", base64_encode(serialize($USER_OBJ)) ,time() + (86400 * 30), "/");
	}
	public function setAvatar($avatarID)
	{
		global $db;
		global $USER_OBJ;
		if(strlen($avatarID) == 0)
			return IO::genErr(1);
		
		$this->avatarID = $avatarID;
		$query=$db->prepare('CALL user_avatar_set(:userID, :avatarID)');
		$query->bindValue(':userID', 	$this->id, 	PDO::PARAM_INT);
		$query->bindValue(':avatarID', 	$this->avatarID);
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				USER::applyUserEdits($this);
				$data = ['avatarID' => $avatarID];
				return IO::showJSres($data );
			}
			else
				return IO::genErr($errcode);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
		
	}
	public static function authLogin($login, $password)
	{
		global $db;
		if(strlen($login) == 0 || strlen($password) == 0)
			return IO::genErr(1);
		
		$password = User::cryptPass($password);
		$query=$db->prepare('CALL user_auth(:login, :password)');
		$query->bindValue(':login', 	$login, 	PDO::PARAM_STR);
		$query->bindValue(':password', 	$password, 	PDO::PARAM_STR);
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$query->closeCursor();
			$errcode = intval($res["errc"]);
			if($errcode == 0)
			{			
				USER::bindData($res);
				return IO::genErr(0);
			}
			else
				return IO::genErr($errcode);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
				
	}
	public function saveInfoToBD()
	{
		global $db;
		
		$query=$db->prepare('CALL user_edit(:id, :password,:name, :email, :instituteID)');
		$query->bindValue(':id', 		$this->id, 							PDO::PARAM_STR);
		$query->bindValue(':password', 	User::cryptPass($this->password), 	PDO::PARAM_STR);
		$query->bindValue(':name', 		$this->name, 						PDO::PARAM_STR);
		$query->bindValue(':email', 	$this->email, 						PDO::PARAM_STR);
		$query->bindValue(':instituteID', 	$this->instituteID, 	PDO::PARAM_STR);
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			if($errcode == 0)
			{		
				$query->closeCursor();
				USER::applyUserEdits($this);
				return IO::genErr(0);
			}
			else
				return IO::genErr($errcode);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
	}
	public function getScore()
	{
		global $db;
		$query=$db->prepare('CALL user_points_get(:id)');
		$query->bindValue(':id', $this->id, 	PDO::PARAM_INT);
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$query->closeCursor();
			$this->points = intval($res['points']);
			return $this->points;
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));
				
	}
	public function getScoreHsitory()
	{
		global $db;
		$query=$db->prepare('CALL user_points_history(:id)');
		$query->bindValue(':id', $this->id, 	PDO::PARAM_INT);
		if($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()));
				
	}
	function createAvatarImage()
	{
		$avatarID = Misc::generate_string();
		
		$imageFilePath = AVATARS_PATH."/{$avatarID}.png";

		//base avatar image that we use to center our text string on top of it.
		$avatar = imagecreatetruecolor(60,60);
		$bg_color = imagecolorallocate($avatar, 211, 211, 211);
		imagefill($avatar,0,0,$bg_color);
		$avatar_text_color = imagecolorallocate($avatar, 0, 0, 0);
		// Load the gd font and write 
		$font = imageloadfont('gd-files/gd-font.gdf');
		imagestring($avatar, $font, 10, 10, $this->login, $avatar_text_color);
		imagepng($avatar, $imageFilePath);
		imagedestroy($avatar);
		setAvatar($avatarID);
		return $imageFilePath;
	}
	private static function bindData($data)
	{
		$user = new User($data['id'], $data['login']) ;
		$user->email = $data['email'];
		$user->avatarID = $data['avatarID'];
		$user->password = $data['password'];
		$user->points = intval($data['points']);
		$user->instituteID = intval($data['instituteID']);
		$user->instituteName = $data['instituteName'];
		/*if($user->avatarID == 0)
			$user->createAvatarImage();*/
		
		$user->name = $data['name'];
		$user->isAdmin = $data['isAdmin'];
		$_SESSION['user'] = $user;
		setcookie("user", base64_encode(serialize($user)) ,time() + (86400 * 30), "/");
		if($user->isAdmin == 1)
		{
			setcookie("admin", true,time() + (86400 * 30), "/");
			$_SESSION['admin'] = true;
		}
	}
	
	
	
}