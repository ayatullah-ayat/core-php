<?php 
if(isset($_POST['where'])) {
	if($_POST['where'] == '1') {
		header("Location: redir1.php");
		return;
	}else if($_POST['where'] == '2') {
		header("Location: redir2.php?param=123");
		return;
	}else{
		header('Location: http://www.google.com');
		return;
	}
}

?>

<html>
	<body>
		<p>Router 2: </p>
		<form method="post">
			<div>Where to go: </div>
			<input type="number" name="where">
			<input type="submit" />
		</form>
	</body>
</html>