<?php
require_once "pdo.php";
include "db-1.php";
/*********************************************
*******************MODEL**********************
**********************************************/


if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
		$sql = "INSERT INTO Users(name, email, password) VALUES(:name, :email, :password)";
		echo("<pre>\n".$sql."\n</pre>\n");
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':name' => $_POST['name'],
			':email' => $_POST['email'],
			':password' => $_POST['password']
		));
		var_dump($_POST);
}
if(isset($_POST['delete']) && isset($_POST['user_id'])) {
	$sql = "DELETE FROM Users WHERE user_id = :user_id";
	echo "<pre>\n$sql\n</pre>\n";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		"user_id" => $_POST['user_id']
	));
}
?>
<!--**************************************
********************VIEW******************
******************************************-->
<html>
	<body>
		<h3>Add A New User</h3>
		<form method="post">
			<div>
				<label>Name: </label>
				<input type="text" name="name">
			</div>
			<div>
				<label>Email: </label>
				<input type="email" name="email">
			</div>
			<div>
				<label>Name: </label>
				<input type="password" name="password">
			</div>
			<input type="submit" name="Add New" value="submit">
		</form>
	</body>
</html>