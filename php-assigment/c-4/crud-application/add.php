<?php 
include_once("bootstrap.php");
include_once("pdo.php");
session_start();

if(!empty($_POST)) {
	if(isset($_POST['user-name']) && isset($_POST['user-email']) && isset($_POST['user-pass'])) {
		$sql = "INSERT INTO users(name, email, password) VALUES(:name, :email, :password)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':name' => $_POST['user-name'],
			':email' => $_POST['user-email'],
			':password' => $_POST['user-pass']
		));
		$_SESSION['success'] = 'Record Added...';
		header('Location: index.php');
		return;
	}
}



?>

<div class="container">
	<div class="row">
		<div class="col-md-5">
			<h2>Add a new user</h2>
			<form method="post">
				<div class="form-group">
					<label for="userName">Name</label>
					<input type="text" class="form-control" name="user-name" id="userName" placeholder="type your name">
				</div>
				<div class="form-group">
					<label for="userEmail">Email</label>
					<input type="email" class="form-control" name="user-email" id="userEmail" placeholder="type your email">
				</div>
				<div class="form-group">
					<label for="userPass">Password</label>
					<input type="text" class="form-control" name="user-pass" id="userEmail" placeholder="type your password">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="index.php">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>