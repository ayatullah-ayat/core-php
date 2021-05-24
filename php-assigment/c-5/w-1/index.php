<?php 
include_once('pdo.php');

$sql = "SELECT  * FROM profile";
$stmt = $pdo->query($sql);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>




<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>

	<div class="container">
		<h1>Ayatullah Khamini's Resume Registry</h1>
		<a href="login.php">Please login</a>

		<?php 
			if(count($rows) > 0) {
				echo "<table border='1'><thead><tr>";
				echo "<th>name</th>";
				echo "<th>headline</th>";
				echo "<tbody>";
				foreach($rows as $row) {
					echo "<tr><td>";
					echo '<a href="view.php?profile_id='.htmlentities($row['profile_id'])."\">";
					echo $row['first_name']. " ". htmlentities($row['last_name']);
					echo "</a></td><td>";
					echo htmlentities($row['headline']);
					echo "</td></tr>";
				}
				echo "</tbody></table>";
			}
		?>

	</div>



</body>
</html>