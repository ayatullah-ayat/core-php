<?php 
include_once("bootstrap.php");
include_once("pdo.php");
session_start();

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
	if(isset($_POST['user-name']) && isset($_POST['user-email']) && isset($_POST['user-pass'])) {
		$sql = "UPDATE users SET name = :name, email = :email, password = :pass WHERE user_id = :user_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':name'=> $_POST['user-name'],
			':email'=> $_POST['user-email'],
			':pass' => $_POST['user-pass'],
			':user_id' => $_POST['user-id']
		));
		$_SESSION['success'] = 'Record Updated';

		header('Location: index.php');

	}
}



$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :id");
$stmt->execute(array(
	':id' => $_GET['user_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $row['name'];
$email = $row['email'];
$pass = $row['password'];
$user_id = $row['user_id'];

if($row == false) {
	$_SESSION['error'] = 'Bad value';
	header('Location: index.php');
	return;
}
?>



<div class="container">
	<div class="row">
		<div class="col-md-5">
			<h2>Update user</h2>
			<form method="post">
				<div class="form-group">
					<label for="userName">Name</label>
					<input type="text" class="form-control" name="user-name" id="userName" value="<?= $name ?>">
				</div>
				<div class="form-group">
					<label for="userEmail">Email</label>
					<input type="email" class="form-control" name="user-email" id="userEmail" value="<?= $email ?>">
				</div>
				<div class="form-group">
					<label for="userPass">Password</label>
					<input type="text" class="form-control" name="user-pass" id="userEmail" value="<?= $pass ?>">
				</div>
				<div class="form-group">
					<input type="hidden" name="user-id" value="<?= $user_id ?>">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="index.php">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>