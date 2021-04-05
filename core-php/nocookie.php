<?php
// Tell PHP we won't be using cookis for the session
ini_set('session.use_cookies', 0);
ini_set('session.use_only_cookies', 0);
ini_set('session.use_trans_sid', 1);
session_start();
?>

<p><strong>No cookies for you</strong></p>
<?php 
	if( !isset($_SESSION['pizza'])) {
		echo "<p>Session is empty</p> \n";
		$_SESSION['pizza'] = 0;
	}else if($_SESSION['pizza'] < 3) {
		$_SESSION['pizza'] = $_SESSION['pizza'] + 1;
		echo "Added one...\$_SESSION['pizza']=". $_SESSION['pizza'] . "\n";
	}else {
		session_destroy();
		session_start();
		echo("<p>Session Restarted</p> \n");
	}
?>

<a href="nocookie.php">Refresh the page</a>
<form action="nocookie.php" method="post">
	<input type="submit" name="click" value="Click This Submit Button!">
</form>
<p>Our session ID is: <? echo session_id() ?></p>