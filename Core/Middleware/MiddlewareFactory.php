<?php

namespace Core\Middleware;

use Core\Exceptions\AppException;

class MiddlewareFactory
{
	public static function createMiddleware($middlewareType = '')
	{
		$className = '';

		switch ($middlewareType)
		{
			case 'routing':
			{
				$className = 'Core\\Middleware\\RoutingMiddleware';
				break;
			}
			default:
			{
				$className = '';
				break;
			}
		}

		if (class_exists($className))
		{
			return new $className();
		}
		else
		{
			throw new AppException("Unable to find Middleware for: " . $className);
		}
	}

}

?>