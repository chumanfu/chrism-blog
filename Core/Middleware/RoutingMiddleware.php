<?php

namespace Core\Middleware;

use Core\Sessions\SessionHandler;
use Core\Config\ConfigReader;
use Core\Middleware\MiddlewareInterface;

class RoutingMiddleware implements MiddlewareInterface
{
	public function canRoute(SessionHandler $sessionHandler, ConfigReader $configReader, $route)
	{
		$canRoute = true;

		$routesWithLogin = $configReader->getConfigSetting('loginrequired', '');

		$loginRoutesArray = explode(',', $routesWithLogin);

		$loggedInUser = $sessionHandler->getSessionValue('loggedin', null);

		if (in_array($route, $loginRoutesArray))
		{
			if (!$loggedInUser)
			{
				$canRoute = false;
			}
		}

		return $canRoute;

	}
}

?>