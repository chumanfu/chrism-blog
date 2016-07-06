<?php

namespace App\Controllers;

use Core\Controller;
use Core\ControllerInterface;

class Login extends Controller implements ControllerInterface
{
	public function index($data)
	{
		$logindata = $data;

		$this->app->view("login");
	}

	public function logout()
	{
		$this->app->killSession();

		$this->app->redirect("posts");
	}

	public function performlogin()
	{
		if ((isset($_POST['txtPassword'])) && ($_POST['txtPassword'] != '') &&
				(isset($_POST['txtEmail'])) && ($_POST['txtEmail'] != ''))
		{
			$password = hash('sha256', $_POST['txtPassword']);

			$user = $this->app->user->checkLogin($_POST['txtEmail'], $password);

			if ($user)
			{
				$this->app->setSessionValue('loggedin', serialize($user));

				$this->app->redirect("posts");
			}
			else
			{
				$this->app->view("login", array('error'=>'Invalid Login Details'));	
			}
		}
		else
		{
			$this->app->view("login", array('error'=>'No Login Details Entered'));
		}
	}

}

?>