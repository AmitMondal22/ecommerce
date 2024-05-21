<?php

$dbservername = "localhost"; // database servername
$dbusername = "root"; // database username
$dbpassword = "root"; // database password
$dbname = "ffc"; // database name

// Create connection
// $con = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname, 3308);
$con = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
    if (!$con) {
    	echo "problem in database connection";
    	exit();
    } 
    /*else {
    	echo "database connected succesfully";
    }*/
    
 
