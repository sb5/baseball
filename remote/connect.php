<?php
 
$dbname = //db
 
$username = //username
 
$password =  //your password

try{
$dbh = new PDO('mysql:host=localhost;dbname='.$db, $username, $password);
}
catch(PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
