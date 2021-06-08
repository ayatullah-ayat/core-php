<?php
/**
 * Created by PhpStorm.
 * User: cuiziang
 * Date: 2018-06-04
 * Time: 8:13 PM
 */
try{
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}

?>
