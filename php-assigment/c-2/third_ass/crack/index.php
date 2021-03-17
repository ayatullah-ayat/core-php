<!DOCTYPE html>
<head><title>Ayatullah Khamini MD5 Cracker</title></head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the PIN.</p>
<pre>
Debug Output:
<?php
$goodtext = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];
    $range = 9;
    $show = 15;
    
    for($i=0; $i<=$range; $i++ ) {
        // Second inner loop
        for($j=0; $j<=$range; $j++) {
            // Third inner loop
            for($k=0; $k<=$range; $k++) {
                // fourth inner loop
                for($l=0; $l<=$range; $l++) {
                    $wrap_nums = ($i.$j.$k.$l);
                    // check
                    $check = hash('md5', $wrap_nums);
                    if($check == $md5) {
                        $goodtext = $wrap_nums;
                        break;
                    }
                    if ( $show > 0 ) {
                        print "$check $wrap_nums\n";
                        $show = $show - 1;
                    }

                }
            }
        }
       
    }
    // Compute elapsed time
    $time_post = microtime(true);
    print "Elapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<!-- Use the very short syntax and call htmlentities() -->
<p>PIN: <?= htmlentities($goodtext); ?></p>
<form>
<input type="text" name="md5" size="60" />
<input type="submit" value="Crack MD5"/>
</form>
</body>
</html>

