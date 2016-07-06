<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{

	public function checkLogin($email, $password)
	{
		$userRecord = $this->select("SELECT * FROM `USERS` WHERE emailaddress=? AND password=?", 
									array('ss'), 
									array($email, $password));	

		if (count($userRecord) == 1)
		{
			return $userRecord[0];
		}
		else
		{
			return null;
		}
	}

	public function getAllUsers()
	{
		return $this->select("SELECT * FROM `USERS` Where id=?", array('i'), array(1));
	}
}

?>