<?php 
include_once("bootstrap.php");
include_once("pdo.php");
session_start();

// delete
if(isset($_POST['user_id']) && isset($_POST['delete'])) {
	$sql = "DELETE FROM users WHERE user_id = :zip";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':zip'=> $_POST['user_id']
	));

	$_SESSION['success'] = "Record Deleted";
	header('Location: index.php');
	return;
}

// Fetch the required user to delete
$sql = "SELECT user_id, name FROM users WHERE user_id = :xyz";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
	':xyz' => $_GET['user_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// check if bad value
if($row == false) {
	$_SESSION['error'] = 'Bad value for user';
}
?>

<div class="container">
	<p>Confirm Deleting: <span class="text-warning"><? echo htmlentities($row['name']) ?></span>
	</p>

	<form method="post">
		<input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
		<button class="btn btn-warning" type="submit" name="delete" value="delete">Delete</button>
		<a href="index.php">Cancel</a>
	</form>
</div>

