<?php 
include_once('pdo.php');
include_once('utility.php');
session_start();

$sql = "SELECT  * FROM profile";
$stmt = $pdo->query($sql);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>




<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    <?php require_once("bootstrap.php"); ?>
</head>
<body>

	<div class="container">
		<h1>Ayatullah Khamini's Resume Registry</h1>
		<?php 
			if(isset($_SESSION['success'])) {
				echo '<p class = "text-success">'. $_SESSION['success'] .'</p>';
				unset($_SESSION['success']);
			}
		?>
		<?php
			if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
				echo '<a href="logout.php">Logout</a>';
				
			}else{
				echo '<a href="login.php">Please log in</a>';
			}
		?>

		<?php 
			if(count($rows) > 0) {
				echo "<table border='1'><thead><tr>";
				echo "<th>Name</th>";
				echo "<th>Headline</th>";
				// IF USER LOGIN SUCCESSFULLY
				if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
					echo "<th>Action</th>";
				}
				echo "<tbody>";
				foreach($rows as $row) {
					echo "<tr><td>";
					echo '<a href="view.php?profile_id='.htmlentities($row['profile_id'])."\">";
					echo $row['first_name']. " ". htmlentities($row['last_name']);
					echo "</a></td><td>";
					echo htmlentities($row['headline']);
					echo "</td>";
					// IF USER LOGIN SUCCESSFULLY
					if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
						echo "<td><a href='edit.php?profile_id=".$row['profile_id']."'>Edit / </a>";
						echo "<a href='delete.php?profile_id=".$row['profile_id']."'>Delete </a></td>";
					}
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
				echo "</br><a href='add.php'>Add New Entry</a>";
			}
		?>

	</div>
</body>
</html>