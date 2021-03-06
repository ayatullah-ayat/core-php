<?php // Do not put any HTML above this line

session_start();
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    session_destroy();
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        $email = strpos($_POST['email'], '@') > 0 ? true : false;
        if(!$email) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
        }
        else if( $check == $stored_hash ) {
            // Redirect the browser to game.php
            $_SESSION['name'] = $_POST['email'];
            header("Location: view.php");
            return;
        } else {
            
            $_SESSION['error'] = "Incorrect password";
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Ayatullah Khamini</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if (isset($_SESSION['error']) && $_SESSION['error'] !== false ) {
    header('Location: login.php');
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);

}
?>
<form method="POST">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
