<?php
include_once('pdo.php');
session_start();

// cancel
if(isset($_POST['cancel'])) {
	header('Location: index.php');
	return;
}
// login
if(!empty($_POST)) {
	$stored_hash = hash('md5', 'XyZzy12*_php123');
	// email and password login validation
	$email = $_POST['email'];
	$password = $_POST['pass'];
	if(!$email || !$password) {
		$_SESSION['error'] = "Email and Password are required";
	}else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }else {
		$valid_pass = hash('md5', 'XyZzy12*_'.$password);
		$stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password= :pw');
		$stmt->execute(array(
			':em'=> $email,
			':pw'=> $valid_pass
		));
		$row = $stmt-> fetch(PDO::FETCH_ASSOC);

		print_r($row);
		if($row){
			error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $row['name'];
			$_SESSION['user_id'] = $row['user_id'];
			print_r($row);
            // header("Location: index.php");
            // return;
		}else {
			$_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']);
            header("Location: login.php");
		}
	}


}


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
			<?php 
				if(isset($_SESSION['error'])) {
					echo "<p class='text-warning'>". $_SESSION['error']."</p>";
					unset($_SESSION['error']);
				}
			?>
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