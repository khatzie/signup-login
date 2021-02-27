<?php
/***  
Database Configuration File
Using Default MySQL Server Setting (user 'root' with no password)  
***/

	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define('DB_NAME', 'db_registration');
	
	$db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME); //Connect to MySQL Database
	
	if($db === false){ //Check if Database is not connected
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>