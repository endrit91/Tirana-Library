<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in(); 
?>

<?php


$current_menu=find_menu_by_id($_GET["menu"],false);

if(!$current_menu){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("manage_content.php");
}
// behet qe te mos fshihet menuja me faqet
$result_page=query_pages_for_menu($current_menu["id"]);
if(mysqli_num_rows($result_page)>0){

	$_SESSION["message"]= "Can not delete menu without deleting its pages first";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php?menu={$current_menu["id"]}");

}

// fillon fshirja
$id=$current_menu["id"];
$query="DELETE FROM menu WHERE id={$id} LIMIT 1";

$result= mysqli_query($connection, $query);



if($result && mysqli_affected_rows($connection)==1) {
	
	$_SESSION["message"]= "Menu deletion Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php");

}else{
	$_SESSION["message"]= "Menu deletion Failed!"; //
	redirect_to("manage_content.php?menu={$id}");

}
?>