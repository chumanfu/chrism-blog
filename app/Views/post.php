<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" context="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<meta name="description" content="">

		<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>

		<title>ChrisM Blog</title>

		<script>

			$(document).ready(function()
			{

				$('#btnLogin').click(function()
			   	{
			   		document.location = '/login';
			   	});
<?php

	if ($pageData['loggedin'])
	{
?>

			   	$('#btnLogout').click(function()
			   	{
			   		document.location = '/login/logout';
			   	});

				$('#btnAdd').click(function()
			   	{
			   		document.location = '/posts/add';
			   	});

				$('.btnDelete').click(function()
			   	{
			   		$('#frmDelete').attr('action', '/posts/delete/'+ $(this).data('id'));

			   		$('#frmDelete').submit();
			   	});

				$('.btnEdit').click(function()
			   	{
			   		document.location = '/posts/edit/' + $(this).data('id');
			   	});

<?php
	}
?>
			});

		</script>

		<style>

			.post_cont
			{
				border-top: solid black 2px;
				width: 500px;
				margin-top: 10px;
				padding-top: 5px;
			}

			.blog_post
			{
				margin-bottom: 10px;
				background-color: #e6f2ff;
			}

			.blog_title
			{
				margin-bottom: 5px;
			}

			.blog_date
			{
				margin-bottom: 5px;
			}

			body
			{
				margin: 15px;
			}

		</style>

	</head>
    <body>

    <h1>ChrisM Blog</h1>

<?php

	if ($pageData['message'] != '')
	{
?>
		<?php echo($pageData['message']);?><br>
<?php
	}

	if ($pageData['loggedin'])
	{
?>
		<h2>Hello <?php echo $pageData['name']; ?></h2>
		<button name="btnLogout" id="btnLogout" >Logout</button>
		<button name="btnAdd" id="btnAdd" >Add New Post</button>
<?php
	}
	else
	{
?>
		<button name="btnLogin" id="btnLogin" >Login</button>
<?php
	}

	if (count($pageData['posts']) > 0)
	{
		foreach ($pageData['posts'] as $post)
		{
?>
			<div class="post_cont">
				<div class="blog_title"><b>Title:</b> <?php echo $post['title'];?></div>
				<b>Post:</b><br>
				<div class="blog_post"><?php echo $post['post'];?></div>
				<div class="blog_date"><b>Created On:</b> <?php echo $post['createdon'];?></div>
<?php
			if ($pageData['loggedin'])
			{
?>
				<button name="btnEdit" id="btnEdit" class="btnEdit" data-id="<?php echo $post['id'];?>">Edit</button>
				<button name="btnDelete" id="btnDelete" class="btnDelete" data-id="<?php echo $post['id'];?>">Delete</button>
<?php
			}
?>
			</div>
<?php
		}
	}
?>

		<form name="frmDelete" id="frmDelete" action="" method="POST">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $pageData['csrf'];?>" />
		</form>
	
		<form name="frmEdit" id="frmEdit" action="" method="POST">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $pageData['csrf'];?>" />
		</form>

    </body>
</html>