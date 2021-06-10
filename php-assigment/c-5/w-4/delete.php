<?php
include_once('pdo.php');
session_start();

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id=:pid");

    $stmt->execute(array(
        ":pid" => $_POST['profile_id']
    ));

    $_SESSION['success'] = "Record deleted";
    header('Location: index.php');
    return;
}


if(!isset($_SESSION['name']) and !isset($_GET['profile_id'])) {
    die('ACCESS DENIED...');
}else {
    $stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id=:pi");
    $stmt->execute(array(
        ":pi"=>$_GET['profile_id']
    ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row) {
        $_SESSION['errors'] = "Error with the database connection";
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

    <div>
        <form method="post">
            <h2>Deleting Profile</h2>
            <p>First Name: <?= $row['first_name'] ?></p>
            <p>Last Name: <?= $row['last_name'] ?></p>
            <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
            <input type="submit" name="delete" value="Delete">
            <a href="index.php">Cancel</a>
        </form>
        
    </div>
</body>
</html>