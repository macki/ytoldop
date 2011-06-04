<?php

class User
{
	private $userID;
	private $nick;
	private $email;
	private $password;
	private $registrationDate;
	private $deleted;
	private $banned;
	private $active;
	private $key;
	private $podlotTeamID;
	private $rankWar;
	
	public function getUserID() { return $this->userID; }
	public function getNick() { return $this->nick; }
	public function getEmail() { return $this->email; }
	public function getPassword() { return $this->password; }
	public function getRegistrationDate() { $this->registrationDate; }
	public function isDeleted() { return $this->deleted; }
	public function isBanned() { return $this->banned; }
	public function isActive() { return $this->active; }
	public function getKey() { return $this->key; }
	public function getPodlotTeamID() { return $this->podlotTeamID; }
	public function getRankWar() { return $this->rankWar; }
	
	public function setNick($val) { $this->nick = $val; }
	public function setPassword($val) { $this->password = $val; }
	public function setKey($val) { $this->key = $val; }
	
	function __construct($nick = null, $email = null, $password = null)
	{
		$this->userID = null;
		$this->nick = $nick;
		$this->email = $email;
		$this->password = $password;
		$this->registrationDate = null;
		$this->deleted = 0;
		$this->banned = 0;
		$this->active = 0;
		$this->key = null;
		$this->podlotTeamID = null;
		$this->rankWar = null;
	}
	
	public function ExistsByEmail()
	{
		$result = DBoperationBasic::ExecuteScalar("select count(*) from users where lower(Email) = lower('".$this->getEmail()."')");
		
		if($result > 0)
			return true;
			
		return false;
	}
	
	public function ExistsByNick()
	{
		$result = DBoperationBasic::ExecuteScalar("select count(*) from users where lower(Nick) = lower('".$this->getNick()."')");
		
		if($result > 0)
			return true;
			
		return false;
	}
	
	public function InsertToDB()
	{
		date_default_timezone_set('Europe/Warsaw');
		
		return DBoperationBasic::ExecuteNonQuery("insert into users(Nick, Email, Password, RegistrationDate, ActKey) values('".$this->getNick()."','".$this->getEmail()."','".$this->getPassword()."','".date('Y-m-d H:i:s')."','".$this->getKey()."')");
	}
	
	public function Activate()
	{
		//Czy user o podanym nicku i kluczu aktywacyjnym istnieje w bazie
		$result = DBoperationBasic::ExecuteScalar("select count(*) from users where lower(Nick) = lower('".$this->getNick()."') and ActKey = '".$this->getKey()."'");
		
		if($result !== false && $result > 0)
		{
			if(DBoperationBasic::ExecuteNonQuery("update users set Active=1, ActKey=NULL where lower(Nick) = lower('".$this->getNick()."')"))
			{
				$this->active = true;
				return true;
			}
		}
		
		return false;
	}
	
	public function IsAuthenticated()
	{
		$result = DBoperationBasic::ExecuteScalar("select count(*) from users where lower(Nick) = lower('".$this->getNick()."') and Password = '".$this->getPassword()."' and Active = 1 and Banned = 0 ");

		//echo "select count(*) from users where lower(Nick) = lower('".$this->getNick()."') and Password = '".$this->getPassword()."' and Active = 1 and Banned = 0 ";
		
		if($result !== false && $result > 0)
			return true;
			
		return false;
	}
}

?>