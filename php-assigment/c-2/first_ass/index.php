<!DOCTYPE html>
<html>
<head>
<title>Ayatullah Khamini PHP</title>
</head>
<body>
<h1>Ayatullah Khamini PHP</h1>
<!-- <p>The SHA256 hash of "Charles Severance" is
347ff2d619a1f6e511410087102dad4e1264767b0a01e7a7fabe662d811ea559</p> -->
<p>The SHA256 hash of "Ayatullah Khamini" is 
	<?php
		print hash('sha256', 'Ayatullah Khamini', false)
	?>
</p>
<pre>ASCII ART:

    ***********
    **       **
    **
    **
    **
    **       **
    ***********
</pre>
<a href="check.php">Click here to check the error setting</a>
<br/>
<a href="fail.php">Click here to cause a traceback</a>

</body>
</html>