<?php

namespace Core\Config\Readers;

use Core\Config\ConfigReader;

class IniConfigReader extends ConfigReader
{
	public function readConfig($configfile)
	{
		$this->configFile = $configfile;

		$this->config = parse_ini_file($this->configFile);
	}
}

?>