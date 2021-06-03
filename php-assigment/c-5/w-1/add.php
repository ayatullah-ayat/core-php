<?php
include_once('pdo.php');

session_start();

if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}



if(!empty($_POST)) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    if(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])){
        
        if(empty($_POST['first_name'])) {
            $_SESSION['errors'] = "All fields are required";
            header("Location: add.php");
            return;
        }if(!ctype_alpha($_POST['first_name'])) {
            $_SESSION['errors'] = "first name shouldn't be numbers or special character";
            header("Location: add.php");
            return;
        }
        if(empty($_POST['last_name'])) {
            $_SESSION['errors'] = "All fields are required";
            header("Location: add.php");
            return;
        }
        if(!ctype_alpha($_POST['last_name'])) {
            $_SESSION['errors'] = "last name shouldn't be numbers or special character";
            header("Location: add.php");
            return;
        }
        if(empty($_POST['headline'])) {
            $_SESSION['errors'] = "All fields are required";
            header("Location: add.php");
            return;
        }
        if(empty($_POST['summary'])) {
            $_SESSION['errors'] = "All fields are required";
            header("Location: add.php");
            return;
        }
        if(!strpos($_POST['email'], '@')) {
            $_SESSION['errors'] = "Email address must contain @";
            header('Location: add.php');
            return;
        }else {
            $sql = "INSERT INTO profile(user_id, first_name, last_name, email, headline, summary) 
            VALUES(:uid, :fn, :ln, :em, :hl, :su) ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                'uid' => $_SESSION['user_id'],
                'fn' => $_POST['first_name'],
                'ln' => $_POST['last_name'],
                'em' => $_POST['email'],
                'hl' => $_POST['headline'],
                'su' => $_POST['summary']
            ));

            $_SESSION['success'] = "profile added";
            header("Location: index.php");
            return;
        }
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
            <input type="text" name="first_name" id="firstName"><br/>

            <label for="lastName">Last Name:</label>
            <input type="text" name="last_name" id="lastName"><br/>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email"><br/>

            <label for="headline">Headline:</label>
            <input type="text" name="headline" id="headline"><br/>

            <label for="summary">Summary:</label>
            <textarea name="summary" rows="8" cols="80"></textarea></br>

            <button type="submit" value="submitted">Add</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>
</body>
</html>