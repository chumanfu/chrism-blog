<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" context="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<meta name="description" content="">

		<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>

		<title>ChrisM Blog - Login</title>

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

		<h1>ChrisM Blog - Login</h1>

    	<form action="/login/performlogin" method="POST">

			<input type="hidden" name="csrf" id="csrf" value="<?php echo $pageData['csrf'];?>" />
    		E-Mail Address: <input type="email" value="" name="txtEmail" maxlength="256" style="width: 310px"/><br>
    		Password: <input type="password" value="" name="txtPassword" maxlength="50" style="width: 310px"/><br>

    		<input type="submit" name="btnSubmit" value="Submit" />
    	</form>

    	<button name="btnCancel" id="btnCancel" >Cancel</button>

    </body>
</html>