<?php
require_once "pdo.php";
// Demand a GET parameter
$warn = false;
$custom_errMessage = false;	
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}if(isset($_POST['logout'])) {
	header('Location: index.php');
	return;
}else if(isset($_POST['add'])) {
	if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])) {
		$custom_errMessage = 'Mileage and year must be numeric';
	}else if(empty($_POST['make'])) {
		$custom_errMessage = 'Make is required';
	}else {
		$sql = "INSERT INTO autos(make, year, mileage) VALUES(:mk, :yr, :mi)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':mk'=> $_POST['make'],
			':yr'=> $_POST['year'],
			':mi'=> $_POST['mileage']
		));
		$warm = true;
		$custom_errMessage = "Record inserted";
	}
}


echo "<h1>Tracking Autos for ". $_GET['name']. "</h1>";
?>

<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Ayatullah Khamini</title>
</head>
<body>

	<?
	if($warn) {
		echo '<p class="text-success">' . $custom_errMessage . '</p>';
	}else{
		echo '<p class="text-danger">' . $custom_errMessage . '</p>';
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
			<input type="submit" name="logout" value="Logout">
		</div>
	</form>
	<?php
		$automobiles = $pdo->query("SELECT * FROM autos");

			echo "AutoMobiles: \n";

			$rows = $automobiles->fetchAll(PDO::FETCH_ASSOC);
			foreach($rows as $row) {
				echo "<ul>\n";
				echo "<li>". htmlentities($row['year']). " ". htmlentities($row['make']). " ". htmlentities($row['mileage']). "</li>";
				echo "</ul>";
			}	?>
</body>
</html>

