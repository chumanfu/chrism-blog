<?php

namespace Core\Config;

abstract class ConfigReader implements ConfigReaderInterface
{
	protected $config = array();
	protected $configFile = '';

	abstract public function readConfig($configfile);

	public function getConfigSetting($key, $default=null)
	{
		if (!empty($this->config[$key]))
		{
			return $this->config[$key];
		}
		else
		{
			return $default;
		}
	}
}

?>