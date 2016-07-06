<?php


spl_autoload_register('__autoload');

function __autoload($class)
{
	$shouldAutoLoad = false;

    $parts = explode('\\', $class);

    if ($parts[0] == 'App')
    {
    	$shouldAutoLoad = true;
    	$class = str_replace('App', 'app', $class);
    }
    elseif ($parts[0] == 'Core')
    {
    	$shouldAutoLoad = true;
    }

    if ($shouldAutoLoad)
    {
		$classFile = "../" . str_replace('\\', '/', $class) . '.php';

		if (file_exists($classFile))
		{
			require $classFile;
		}
		else
		{
			throw new Exception("ERROR: Missing class file: " .  $classFile . "\n");
		}
	}
}



?>