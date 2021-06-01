<?php
include_once('pdo.php');
session_start();
if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if(!empty($_POST)) {
    

    print_r($_POST);

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
            <input type="text" name="first-name" value=<?= $row['first_name'] ?> id="firstName"><br/>

            <label for="lastName">Last Name:</label>
            <input type="text" name="last-name" value=<?= $row['last_name'] ?> id="lastName"><br/>

            <label for="email">Email:</label>
            <input type="text" name="email" value=<?= $row['email'] ?> id="email"><br/>

            <label for="headline">Headline:</label>
            <input type="text" name="headline" value=<?= $row['headline'] ?> id="headline"><br/>

            <label for="summary">Summary:</label>
            <textarea name="summary" rows="8" cols="80"><?= $row['summary'] ?></textarea></br>
            <input type="hidden" name="user_id" value = <?= $row['user_id'] ?>>
            <button type="submit" value="submitted">Add</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>
</body>
</html>