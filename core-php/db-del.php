<?php
require_once "pdo.php";
// MODEL
if(isset($_POST['user_id'])) {
	$sql = "DELETE FROM Users WHERE user_id = :user_id";
	echo "<pre>\n$sql\n</pre>\n";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		"user_id" => $_POST['user_id']
	));
}
?>
<p>Delete A User</p>
<form method="post">
	<label>ID to Delete</label>
	<input type="text" name="user_id">
	<br>
	<input type="submit" value="Delete">
</form>