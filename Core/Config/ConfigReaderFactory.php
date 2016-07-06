<?php

namespace Core\Config;

use Core\Exceptions\AppException;

class ConfigReaderFactory
{
	public static function createConfigReader($readerType = '')
	{
		$className = '';

		switch ($readerType)
		{
			case 'ini':
			{
				$className = 'Core\\Config\\Readers\\IniConfigReader';
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
			throw new AppException("Unable to find Config Reader for: " . $className);
		}
	}

}

?>