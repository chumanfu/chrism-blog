<?php

namespace App\Controllers;

use Core\Controller;
use Core\ControllerInterface;

class Posts extends Controller implements ControllerInterface
{
	public function index($var)
	{
		$posts = $this->app->post->getPosts(0);

		$loggedInUser = $this->app->getSessionValue('loggedin', null);

		$name = '';
		$message = '';

		if ($loggedInUser)
		{
			$loggedInUser = unserialize($loggedInUser);

			$name = $loggedInUser['firstname'] . " " . $loggedInUser['lastname'];
		}

		if ($var == 'added')
		{
			$message = 'New Blog Post Added';
		}
		else if ($var == 'deleted')
		{
			$message = 'Blog Post Deleted';
		}
		else if ($var == 'updated')
		{
			$message = 'Blog Post Updated';
		}

		foreach ($posts as &$post)
		{
			$post['post'] = strlen($post['post']) > 100 ? substr($post['post'],0,100)."..." : $post['post'];
		}

		$this->app->view('post', array(
										'message'=>$message, 
										'loggedin' => ($name!=''), 
										'name' => $name, 
										'posts' => $posts));
	}

	public function delete($id)
	{
		$this->app->post->deletePost($id);

		$this->app->redirect('posts/deleted');
	}

	public function edit($id)
	{
		$loggedInUser = $this->app->getSessionValue('loggedin', null);
		$loggedInUser = unserialize($loggedInUser);

		$pageData = array('error'=>'');

		if (isset($_POST['btnSubmit']))
		{

			if (!$this->checkCSRF())
			{
				echo "Invalid Request";
				exit(1);
			}

			if (!isset($_POST['txtPost']))
			{
				$pageData['error'] .= "Error: Missing post body\n";
			}
			
			if (!isset($_POST['txtTitle']))
			{
				$pageData['error'] .= "Error: Missing post title\n";
			}

			if ($pageData['error'] == '')
			{
				$this->app->post->updatePost($_POST['txtPost'], $_POST['txtTitle'], $_POST['txtID']);

			}

			if ($pageData['error'] != '')
			{
				$this->app->view('edit', $pageData);
			}
			else
			{
				$this->app->redirect('posts/updated');
			}
		}
		else
		{
			$postData = $this->app->post->getPost($id);

			$pageData['post'] = $postData['post'];
			$pageData['title'] = $postData['title'];
			$pageData['id'] = $id;

			$this->app->view('edit', $pageData);
		}
	}

	public function add()
	{

		$loggedInUser = $this->app->getSessionValue('loggedin', null);
		$loggedInUser = unserialize($loggedInUser);

		$pageData = array('error'=>'');

		if (isset($_POST['btnSubmit']))
		{

			if (!$this->checkCSRF())
			{
				echo "Invalid Request";
				exit(1);
			}

			if (!isset($_POST['txtPost']))
			{
				$pageData['error'] .= "Error: Missing post body\n";
			}
			
			if (!isset($_POST['txtTitle']))
			{
				$pageData['error'] .= "Error: Missing post title\n";
			}

			if ($pageData['error'] == '')
			{
				$postID = $this->app->post->addPost($_POST['txtTitle'], $_POST['txtPost'], $loggedInUser['id']);

				if ($postID == -1)
				{
					$pageData['error'] .= "Error: Unable to add post\n";
				}
			}

			if ($pageData['error'] != '')
			{
				$this->app->view('add_post', $pageData);
			}
			else
			{
				$this->app->redirect('posts/added');
			}
		}
		else
		{
			$this->app->view('add_post', $pageData);
		}
	}

}

?>