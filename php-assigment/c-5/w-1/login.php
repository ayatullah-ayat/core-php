<?php

?>


<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    <?php require_once "bootstrap.php"; ?>
</head>
	<body>
		<div class="container pt-2">
			<p>Login:</p>
			<form method="POST">
				<label for="email">Email</label>
				<input type="text" name="email" id="email"><br/>

				<label for="userPass">Password</label>
				<input type="text" name="pass" id="userPass"><br/>
				
				<input type="submit" value="Log In">
				<input type="submit" name="cancel" value="Cancel">
			</form>
		</div>
	</body>

</html>