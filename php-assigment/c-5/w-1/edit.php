<?php
include_once('pdo.php');
session_start();
if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}
if(!isset($_SESSION['name'])) {
    die('Not logged in');
}
if(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])) {
    
    if(!strpos($_POST['email'], '@')) {
        $_SESSION['errors'] = "Email address must contain @";
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }else {
        $stmt = $pdo->prepare("UPDATE Profile SET first_name = :fn, last_name = :ln, email = :em, headline = :hl, summary = :su WHERE profile_id = :pid");

        $stmt->execute(array(
            "pid" => $_GET['profile_id'],
            "fn" => $_POST['first_name'],
            "ln" => $_POST['last_name'],
            "em" => $_POST['email'],
            "hl" => $_POST['headline'],
            "su" => $_POST['summary']
        ));
        $_SESSION['success'] = "Profile Updated";
        header("Location: index.php");
        return;
    }

}



if(isset($_SESSION['name']) and isset($_GET['profile_id'])) {
    // fetch data
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
    <h1>Adding Profile for <?= $_SESSION['name'] ?></h1>

    <div class="container">
    <?php 
        if(isset($_SESSION['errors'])) {
            echo '<p class="text-warning">'. $_SESSION['errors']. '</p>';
            unset($_SESSION['errors']);
        }
    ?>
        <form method="post">
            <label for="firstName">First Name:</label>
            <input type="text" name="first_name" value=<?= $row['first_name'] ?> id="firstName"><br/>

            <label for="lastName">Last Name:</label>
            <input type="text" name="last_name" value=<?= $row['last_name'] ?> id="lastName"><br/>

            <label for="email">Email:</label>
            <input type="text" name="email" value=<?= $row['email'] ?> id="email"><br/>

            <label for="headline">Headline:</label>
            <input type="text" name="headline" value=<?= $row['headline'] ?> id="headline"><br/>

            <label for="summary">Summary:</label>
            <textarea name="summary" rows="8" cols="80"><?= $row['summary'] ?></textarea></br>
            <input type="hidden" name="profile_id" value = <?= $row['profile_id'] ?>>
            <input type="submit" value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>
</html>