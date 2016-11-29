<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in(); 
?>

<?php


$current_page=find_page_by_id($_GET["pages"], false);

if(!$current_page){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("manage_content.php");
}
// behet qe te mos fshihet menuja me faqet


// fillon fshirja
$id=$current_page["id"];
$query="DELETE FROM pages WHERE id={$id} LIMIT 1";

$result= mysqli_query($connection, $query);



if($result && mysqli_affected_rows($connection)==1) {
	
	$_SESSION["message"]= "Menu deletion Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php");

}else{
	$_SESSION["message"]= "Menu deletion Failed!"; //
	redirect_to("manage_content.php?pages={$id}");

}
?>