<?php
session_start();

if( !isset($_SESSION['pizza'])) {
	echo "<p>Session is empty</p> \n";
	$_SESSION['pizza'] = 0;
}else if($_SESSION['pizza'] < 3) {
	$_SESSION['pizza'] = $_SESSION['pizza'] + 1;
	echo "Added one... \n";
}else {
	session_destroy();
	session_start();
	echo("<p>Session Restarted</p> \n");
}

?>

<a href="sessfun.php">Refresh the page</a>
<p>Our session id id: <? echo session_id(); ?></p>
<pre>
	<? print_r($_SESSION); ?>
</pre>