<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" context="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<meta name="description" content="">

		<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>

		<title>ChrisM Blog - Add New Post</title>

		<script>

			$(document).ready(function()
			{
			   	$('#btnCancel').click(function()
			   	{
			   		document.location = '/posts';
			   	});

			});

		</script>

	</head>
    <body>

<?php
	if (!empty($pageData['error']))
	{
		echo($pageData['error']);
	}
?>

		<h1>Add New Post</h1>

    	<form action="/posts/add" method="POST">

			<input type="hidden" name="csrf" id="csrf" value="<?php echo $pageData['csrf'];?>" />
    		<label for="txtTitle">Title:</label><input type="text" maxlength="50" style="width: 310px" value="" name="txtTitle"/><br>
    		<label for="txtPost">Post:</label><textarea name="txtPost" rows="10" cols="50"></textarea><br>

    		<input type="submit" name="btnSubmit" value="Submit" />
    	</form>
    	
    	<button name="btnCancel" id="btnCancel" >Cancel</button>

    </body>
</html>