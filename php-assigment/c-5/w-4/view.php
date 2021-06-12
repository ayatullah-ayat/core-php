<?php 
include_once('pdo.php');
include_once('utility.php');

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

	// query into the education table, and fetch all the education data

	$stmt = $pdo->prepare('SELECT Education.year, Institution.name FROM Education INNER JOIN Institution ON Education.profile_id = :id AND Education.institution_id = Institution.institution_id');
	$stmt->execute(array(
		':id' => $profile_id
	));
	$eduRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
			<p>Position: </p>
			<? foreach($posRow as $row) { ?>
				<ul>
					<li><?= htmlentities($row['year']).', ' . htmlentities($row['description']) ?></li>
				</ul>
			<? } ?>
		<? } ?>
		<? if($eduRow){ ?>
			<p>Education: </p>
			<? foreach($eduRow as $row) { ?>
				<ul>
					<li><?= htmlentities($row['year']).', ' . htmlentities($row['name']) ?></li>
				</ul>
			<? } ?>
		<? } ?>
		<a href="index.php">Back</a>

	</div>

</body>
</html>