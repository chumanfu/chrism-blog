<?php

require "bootstrap.php";

use Core\Application;

try
{
	$application = new Application('../app/config/chrismblog.ini');

	$application->implementRouting();

}
catch (Core\Exceptions\AppException $e)
{
	echo($e->getMessage() . "\n");
	exit(1);
}


?>