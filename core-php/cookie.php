<?php
if(!isset($_COOKIE['zap'])) {
	setcookie('zap', 42, time()+3600);
}
?>
<pre>
	<? print_r($_COOKIE); ?>
	<br>
	<? print_r($_SERVER); ?>
</pre>
<a href="cookie.php">click me</a>