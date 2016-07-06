<?php

namespace Core\Database;

use Core\Exceptions\AppException;

class DatabaseFactory
{

	public static function createConnection($dbhost, $dbname, $dbuser, $dbpassword)
	{
		$connection = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);

		if (mysqli_connect_errno())
		{
			throw new AppException("Unable to connect to database: " . mysqli_connect_errno());
		}

		return $connection;
	}

}

?>