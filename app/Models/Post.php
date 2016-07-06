<?php

namespace App\Models;

use Core\Model\Model;

class Post extends Model
{

	public function updatePost($post, $title, $id)
	{
		return $this->execute("UPDATE `POSTS` SET `post`=?, `title`=? WHERE id=?", array('s','s','i'), array($post, $title, $id));
	}

	public function getPost($id)
	{
		$postArray = $this->select("SELECT `id`, `title`, `post`, `createdby`, `createdon` FROM `POSTS` WHERE `id`=?", array('i'), array($id));	

		if (count($postArray) > 0)
		{
			return $postArray[0];
		}
		else
		{
			return null;
		}
	}

	public function getPosts($from)
	{
		return $this->select("SELECT `id`, `title`, `post`, `createdby`, `createdon` FROM `POSTS` ORDER BY ID DESC LIMIT 5 ");
	}

	public function deletePost($id)
	{
		return $this->execute("DELETE FROM `POSTS` WHERE id=?", array('i'), array($id));
	}

	public function addPost($postTitle, $postBody, $userID)
	{
		$values = array('title'=>$postTitle, 'post'=>$postBody, 'createdby'=>$userID);

		return $this->insert("INSERT INTO POSTS (`title`, `post`, `createdby`, `createdon`) VALUES (?,?,?,NOW())", $values, "ssi");
	}
}

?>