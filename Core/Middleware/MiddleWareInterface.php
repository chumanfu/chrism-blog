<?php

namespace Core\Middleware;

use Core\Sessions\SessionHandler;
use Core\Config\ConfigReader;

interface MiddlewareInterface
{
	public function canRoute(SessionHandler $sessionHandler, ConfigReader $configReader, $route);
}

?>