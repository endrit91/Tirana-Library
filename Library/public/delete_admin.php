<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in(); 
?>

<?php


$admin= find_admin_by_id($_GET["id"]);

if(!$admin){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("manage_admins.php");
}
// behet qe te mos fshihet menuja me faqet

// fillon fshirja
$id=$admin["id"];
$query="DELETE FROM admins WHERE id={$id} LIMIT 1";

$result= mysqli_query($connection, $query);



if($result && mysqli_affected_rows($connection)==1) {
	
	$_SESSION["message"]= "Admin deletion Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_admins.php");

}else{
	$_SESSION["message"]= "Admin deletion Failed!"; //
	redirect_to("manage_admins.php");

}
?>