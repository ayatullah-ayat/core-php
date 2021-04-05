<?php
session_start();
require_once('pdo.php');
if(!isset($_SESSION['name'])) {
	die('Not logged in');
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Ayatullah Khamini</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
	<? if(isset($_SESSION['name'])) { ?>
		<h2>Tracking Autos for <?php echo $_SESSION['name']; ?></h2>
		<h3>Automobiles</h3>
		<?php 
			$automobiles = $pdo->query("SELECT * FROM autos");

			$rows = $automobiles->fetchAll(PDO::FETCH_ASSOC);
			foreach($rows as $row) {
				echo "<ul>\n";
				echo "<li>". htmlentities($row['year']). " ". htmlentities($row['make']). " / ". htmlentities($row['mileage']). "</li>";
				echo "</ul>";
			}
		?>
		<a href="add.php">Add New </a>|
		<a href="logout.php">Logout</a>
	<? } ?>

</body>
</html>