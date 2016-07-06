<?php

namespace Core;

use Core\Exceptions\AppException;
use Core\Sessions\SessionFactory;
use Core\Database\DatabaseFactory;
use Core\Middleware\MiddlewareFactory;
use Core\Config\ConfigReaderFactory;

class Application
{
	private $configReader;
	private $sessionHandler;
	private $databaseConnection;
	private $objectArray = array();

	function __construct($configFile)
	{
		if (!file_exists($configFile))
		{
			throw new AppException("Config file missing: " . $configFile);
		}

		$pathParts = pathinfo($configFile);

		$this->configReader = ConfigReaderFactory::createConfigReader($pathParts['extension']);

		$this->configReader->readConfig($configFile);

		$this->sessionHandler = SessionFactory::createSessionHandler($this->getConfigSetting('sessiontype', ''));

		$this->sessionHandler->startSession();

		if ($this->sessionHandler->getSessionValue('csrf', '') == '')
		{
			$this->sessionHandler->setSessionValue('csrf', base64_encode(openssl_random_pseudo_bytes(32)));
		}

		$this->objectArray['middleware']['routing'] = MiddlewareFactory::createMiddleware('routing');

		$this->databaseConnection = DatabaseFactory::createConnection($this->configReader->getConfigSetting('dbhost'),
																		$this->configReader->getConfigSetting('dbname'),
																		$this->configReader->getConfigSetting('dbuser'),
																		$this->configReader->getConfigSetting('dbpassword'));

		if ($handle = opendir('../app/Models'))
		{
			while (false !== ($modelClass = readdir($handle)))
			{
				if (($modelClass != '.') && ($modelClass != '..'))
				{
					$basename = basename($modelClass);

					$basename = strtolower(str_replace('.php', '', $basename));

					$className = 'App\\Models\\' . $basename;

	        		$this->objectArray['models'][$basename] = new $className($this->databaseConnection);
	        	}
    		}
		}

	}

	public function canRoute($route)
	{
		return $this->routing->canRoute($this->sessionHandler, $this->configReader, $route);
	}

	public function redirect($page)
	{
		header('Location: ' . $this->getConfigSetting('baseurl') . "/" . $page, true, 302);
	}

	public function view($page, $pageData = array())
	{
		$pageData['csrf'] = $this->sessionHandler->getSessionValue('csrf', '');

		require("../app/Views/" . $page . ".php");
	}

	public function __get($name)
	{
		if (!empty($this->objectArray['models'][$name]))
		{
			return $this->objectArray['models'][$name];
		}
		else if (!empty($this->objectArray['middleware'][$name]))
		{
			return $this->objectArray['middleware'][$name];
		}
		else
		{
			throw new AppException("Object missing: " . $name);
		}
	}

	public function setSessionValue($key, $value)
	{
		return $this->sessionHandler->setSessionValue($key, $value);
	}

	public function getSessionValue($key)
	{
		return $this->sessionHandler->getSessionValue($key, null);
	}

	public function killSession()
	{
		$this->sessionHandler->endSession();
	}

	public function implementRouting()
	{
		$urlParts = explode('/', $_SERVER['REQUEST_URI']);

		$controller = null;
		$class = '';
		$route = $urlParts[1];

		if (($class = $this->getConfigSetting($route, '')) != '')
		{
			$className = "App\\Controllers\\" . $class;
			
		}
		else
		{
			if ($route == '')
			{
				$className = "App\\Controllers\\" . $this->getConfigSetting('defaultroute', '');
			}
		}

		if ($className != '')
		{
			$controller = new $className($this);
		}

		if ($controller)
		{
			$var = null;
			$method = null;

			if ((count($urlParts) > 2) && (($method = $urlParts[2]) != ''))
			{
				if (count($urlParts) == 4)
				{
					$var = $urlParts[3];
				}
			}
			
			$controller->_index($route, $method, $var);
		}
		else
		{
			throw new AppException("Controller not found: " . $class);
		}
	}

	public function getConfigSetting($setting, $default=null)
	{
		return $this->configReader->getConfigSetting($setting, $default);
	}

}

?>