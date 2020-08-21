<?

class Event
{
	public $id 			= 0;
	public $name 		= '';
	public $dtStart		= '';
	public $dtEnd		= '';
	public $hash 		= '';
	public $points 		= 0;
	public $isChecked 	= false;
	function __construct($id) 
	{
		$this->id = $id;
	}
	
	public static function create($name, $points,$dtStart, $dtEnd)
	{
		global $db;
		if(intval($points) == 0 || strlen($name) == 0 || strlen($dtStart) == 0 || strlen($dtEnd) == 0)
			exit(IO::genErr(1));
		
		$event = new Event(0);
		$event->name = $name;
		$event->points = $points;
		$event->dtStart = $dtStart;
		$event->dtEnd = $dtEnd;
		
		$query=$db->prepare('CALL event_create(:name, :points,:dtStart, :dtEnd)');
		$query->bindValue(':name', 		$name, 		PDO::PARAM_STR);
		$query->bindValue(':points', 	$points, 	PDO::PARAM_INT);
		$query->bindValue(':dtStart', 	$dtStart, 	PDO::PARAM_STR);
		$query->bindValue(':dtEnd', 	$dtEnd, 	PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				$event->id	 = intval($res['id']);
				$event->hash = intval($res['hash']);
				return $event;
			}
			else
				exit(IO::genErr($errcode));
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	
	public function saveEdits()
	{
		global $db;
		if(intval($this->points) == 0 || strlen($this->name) == 0 || strlen($this->dtStart) == 0 || strlen($this->dtEnd) == 0)
			exit(IO::genErr(1));
		
		
		$query=$db->prepare('CALL event_update(:eventID,:name, :points,:dtStart, :dtEnd)');
		$query->bindValue(':eventID', 	$this->id, 		PDO::PARAM_STR);
		$query->bindValue(':name', 		$this->name, 		PDO::PARAM_STR);
		$query->bindValue(':points', 	$this->points, 	PDO::PARAM_STR);
		$query->bindValue(':dtStart', 	$this->dtStart, 	PDO::PARAM_STR);
		$query->bindValue(':dtEnd', 	$this->dtEnd, 	PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				return $this;
			}
			else
				exit(IO::genErr($errcode));
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	
	public function load_admin()
	{
		global $db;
		
		$query=$db->prepare('CALL event_load_admin(:eventID)');
		$query->bindValue(':eventID', 	$this->id, 		PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				$this->name 		= $res['name'];
				$this->dtStart		= $res['dtStart'];
				$this->dtEnd		= $res['dtEnd'];
				$this->hash 		= $res['hash'];
				$this->points 		= $res['points'];
				$this->usersChecked = $res['usersChecked'];
				return $this;
			}
			else
				exit(IO::genErr($errcode));
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	public static function role_acquire($hash)
	{
		global $db;
		global $USER_OBJ;
		
		$query=$db->prepare('CALL role_link_acquire(:hash, :userID)');
		$query->bindValue(':hash', 		$hash, 			PDO::PARAM_STR);
		$query->bindValue(':userID', 	$USER_OBJ->id, 	PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				return [0,$res];
			}
			else
				return [$errcode,IO::getErrText($errcode)];
		}
		else
			return [3, "MySQL:".json_encode($query->errorInfo()) ];

	}
	public function link_create($role)
	{
		global $db;
		
		$query=$db->prepare('CALL role_link_create(:eventID, :role_set)');
		$query->bindValue(':eventID', 	$this->id, 	PDO::PARAM_INT);
		$query->bindValue(':role_set', 	$role, 		PDO::PARAM_INT);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				$this->rolesLinks[] = Event::get_roles_link_from_hash($res['hash']);
				return Event::get_roles_link_from_hash($res['hash']);
			}
			else
				exit(IO::genErr($errcode));
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	
	public static function get_roles()
	{
		global $db;
		
		$query=$db->prepare('SELECT `id`, `name` FROM `roles`');
		
		if($query->execute())
		{
			return  $query->fetchAll(PDO::FETCH_ASSOC);
			
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	public  static function get_roles_link_from_hash($hash)
	{
		return ROLES_LINK_PATH.$hash;
	}
	
	public function load_roles_links()
	{
		global $db;
		
		$query=$db->prepare('CALL role_link_list(:eventID)');
		$query->bindValue(':eventID', 	$this->id, 		PDO::PARAM_STR);
		
		if($query->execute())
		{
			$this->rolesLinks = $query->fetchAll(PDO::FETCH_ASSOC);
			$links = [];

			foreach($this->rolesLinks as $value)
			{
				$value['link'] = Event::get_roles_link_from_hash($value['link']);
				$links[] = $value;
			}
			$this->rolesLinks = $links;
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	
	public function load_checked_users()
	{
		global $db;
		
		$query=$db->prepare('CALL event_load_checkers(:eventID)');
		$query->bindValue(':eventID', 	$this->id, 		PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			$this->users=$res;
		}
		else
			exit(IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo())));

	}
	
	public static function checkin($hash)
	{
		global $db;
		global $USER_OBJ;
		if(strlen($hash) == 0)
			return IO::genErr(1);
		
		if( strstr("code", $hash) || strstr("/", $hash) || strstr("=", $hash))
		{
			if( strstr("/", $hash))
				$hash = substr($hash, strpos($hash, "/") + 1);    
			if( strstr("=", $hash))
				$hash = substr($hash, strpos($hash, "=") + 1);    
		}
		$query=$db->prepare('CALL event_checkin(:hash, :userID)');
		$query->bindValue(':hash', 		$hash, 			PDO::PARAM_STR);
		$query->bindValue(':userID', 	$USER_OBJ->id, 	PDO::PARAM_STR);
		
		if($query->execute())
		{
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$errcode = intval($res["errc"]);
			$query->closeCursor();
			if($errcode == 0)
			{		
				return [0,$res];
			}
			else
				return [$errcode,IO::getErrText($errcode)];
		}
		else
			return IO::genErrMsg(3, "MySQL:".json_encode($query->errorInfo()))	;

	}
	
	
	
}