<?php
try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 
        'root', 'root');
} catch (Exception $e) {
	echo($e->getMessage());  
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
