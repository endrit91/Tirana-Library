<?php
define("DB_SERVER", "localhost");  // ngaqe nuk ndryshojne si vlera me mireperdorim constants
define("DB_USER", "endrit");
define("DB_PASS", "12345");
define("DB_NAME", "library");

$connection= mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
/* 
// 1. create db connnection
$dbhost= "localhost";
$dbuser= "endrit";
$dbpass= "12345";
$dbname= "library";
$connection= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

*/             
// 1.2. test if connected

if(mysqli_connect_errno()) {
	die ("Database connection failed:". "-".
		mysqli_connect_error(). "-".
		mysqli_connect_errno() );
}
?>