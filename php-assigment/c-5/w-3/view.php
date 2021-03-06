<?php 
include_once('pdo.php');

if(array_key_exists('profile_id', $_GET)) {
	$profile_id = $_GET['profile_id'];

	$sql = "SELECT * FROM profile WHERE profile_id = :id";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':id' => $profile_id
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($row) {
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$email = $row['email'];
		$headline = $row['headline'];
		$summary = $row['summary'];
	}


	// Fetching position data from databse table and display them if they are...
	$stmt = $pdo->prepare('SELECT * FROM position WHERE profile_id = :id');
	$stmt->execute(array(
		':id' => $profile_id
	));
	$posRow = $stmt->fetchAll(PDO::FETCH_ASSOC);


	
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>

	<div class="container">
		<h1>Profile Information</h1>
		<? if($row){ ?>
			<p>first name: <strong><?= htmlentities($first_name) ?></strong> </p>
			<p>last name: <strong><?= htmlentities($last_name) ?> </strong></p>
			<p>Email: <strong><?= htmlentities($email) ?> </strong></p>
			<p>Headline: <strong><?= htmlentities($headline) ?></strong> </p>
			<p>Summary: <strong><?= htmlentities($summary) ?> </strong></p>
		<? } ?>
		<? if($posRow){ ?>
			<p>Position:</p>
			<? foreach($posRow as $row) { ?>
				<ul>
					<li>year: <?= htmlentities($row['year']) ?></li>
					<li>description: <?= htmlentities($row['description']) ?></li>
				</ul>
			<? } ?>
		<? } ?>
		<a href="index.php">Back</a>

	</div>

</body>
</html>