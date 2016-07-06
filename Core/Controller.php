<?php

namespace Core;

class Controller
{
	protected $app = null;

	function __construct($app)
	{
		$this->app = $app;
	}

	public function _index($route=null, $method=null, $var=null)
	{
		$methodCalled = false;

		if ($method)
		{
			if (method_exists($this, $method))
			{
				if ($this->app->canRoute($route . '/' . $method))
				{
					$this->$method($var);
					$methodCalled = true;
				}
				else
				{
					echo "You need to be logged in";
					exit;
				}
			}
		}

		if (!$methodCalled)
		{
			if (!$this->app->canRoute($route))
			{
				echo "You need to be logged in";
				exit;
			}
			else
			{
				$this->index($method);
			}
		}
	}

	public function checkCSRF()
	{
		$return = true;

		if (!isset($_POST['csrf']))
		{
			$return = false;
		}
		else
		{
			if ($_POST['csrf'] != $this->app->getSessionValue('csrf', ''))
			{
				$return = false;
			}
		}

		return $return;
	}

}

?>