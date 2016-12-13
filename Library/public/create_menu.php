<?php // ketu bejme procesimin me databasen
require_once("../includes/sessions.php"); 

require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in();
require_once("../includes/validation_functions.php");
?>
<?php
if (isset($_POST['submit'])){
// process the form

// 2. Perform database QUERY
$menu_name=  mysql_escape($_POST['menu_name']);
$position= (int) $_POST['position'];
$visible= (int) $_POST['visible'];

// validations
$required_fields = array("menu_name", "position","visible"); //sifillim ivendosim ne POST ne array, me qellim validimin
validate_presences($required_fields);
$fields_with_max_lengths=array("menu_name" => 30);
validate_max_lengths($fields_with_max_lengths);

if (!empty($errors)){
	$_SESSION["errors"]= $errors;
	redirect_to("new_menu.php");
}

// querin gjithmone e bejme pasi bejme validimet
$query = "INSERT INTO menu (";
$query.= " menu_name,position,visible";
$query.= ") VALUES (";

$query.= " '{$menu_name}', {$position}, {$visible}";
$query.= ")";

$result= mysqli_query($connection, $query);

if($result) {
	
	$_SESSION["message"]= "Menu creation Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php");

}else{
	$_SESSION["message"]= "Menu creation Failed!"; //
	redirect_to("new_menu.php");
}




}else{
	// ne rast se nuk na vjen nga posti, dmth vje nga GET
redirect_to("new_menu.php");
}


?>
<?php
// 5.  Close db connection, fromthe footer
if (isset($connection)){   
mysqli_close($connection);
}
?>
