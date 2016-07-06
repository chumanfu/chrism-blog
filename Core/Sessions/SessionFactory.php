<?php

namespace Core\Sessions;

use Core\Exceptions\AppException;

class SessionFactory
{
	public static function createSessionHandler($handlerType = '')
	{
		$className = '';

		switch ($handlerType)
		{
			case '':
			case 'standard':
			{
				$className = 'Core\\Sessions\\Handlers\\StandardSessionHandler';
				break;
			}
			case 'db':
			{
				$className = 'Core\Sessions\\Handlers\\DBSessionHandler';
				break;
			}
			default:
			{
				$className = 'App\\Sessions\\Handlers\\' . $handlerType;
				break;
			}
		}

		if (class_exists($className))
		{
			return new $className();
		}
		else
		{
			throw new AppException("Unable to find Session Handler for: " . $className);
		}
	}

}

?>