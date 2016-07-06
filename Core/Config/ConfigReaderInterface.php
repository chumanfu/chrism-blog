<?php

namespace Core\Config;

interface ConfigReaderInterface
{
	public function readConfig($configfile);
	public function getConfigSetting($key, $default=null);
}

?>