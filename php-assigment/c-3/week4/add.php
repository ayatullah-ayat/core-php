<?php
session_start();
require_once "pdo.php";
// Demand a GET parameter


if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1  ) {
    die('Not logged in');
}if(isset($_POST['cancel'])) {
	header('Location: view.php');
	return;
}else if(isset($_POST['add'])) {
	if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])) {
		$_SESSION['error'] = 'Mileage and year must be numeric';
	}else if(empty($_POST['make'])) {
		$_SESSION['error'] = 'Make is required';
	}else {
		$sql = "INSERT INTO autos(make, year, mileage) VALUES(:mk, :yr, :mi)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':mk'=> $_POST['make'],
			':yr'=> $_POST['year'],
			':mi'=> $_POST['mileage']
		));
		$_SESSION['success'] = "Record inserted";
		header('Location: view.php');
	}
}


echo "<h1>Tracking Autos for ". $_SESSION['name']. "</h1>";
?>

<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Ayatullah Khamini</title>
</head>
<body>

	<?
	if(isset($_SESSION['error'])){
		header('Location: add.php');
		echo '<p style="color:red;">' . htmlentities($_SESSION['error']) . '</p>';
			unset($_SESSION['error']);

		}
	?>
	<form method="post">
		<div>
			<label>Make: </label>
			<input type="text" name="make">
		</div>
		<div>
			<label>Year: </label>
			<input type="text" name="year">
		</div>
		<div>
			<label>Mileage: </label>
			<input type="text" name="mileage">
		</div>
		<div>
			<input type="submit" name="add" value="Add">
			<input type="submit" name="cancel" value="cancel">
		</div>
	</form>
	
</body>
</html>

