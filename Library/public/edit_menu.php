<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
require_once("../includes/validation_functions.php");
confirm_logged_in();

find_selected_page(); 

if(!$current_menu){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("manage_content.php");
}
//.........................
//form processing
if (isset($_POST['submit'])){
// process the form

// 2. Perform database QUERY


// validations// i bejme qe ne fiillim sepse me pas do i ndryshojme vlerat
$required_fields = array("menu_name", "position","visible"); //sifillim ivendosim ne POST ne array, me qellim validimin
validate_presences($required_fields);
$fields_with_max_lengths=array("menu_name" => 30);
validate_max_lengths($fields_with_max_lengths);

if (empty($errors)){

	// perform update
$id= $current_menu["id"];
$menu_name=  mysql_escape($_POST['menu_name']);
$position= (int) $_POST['position'];
$visible= (int) $_POST['visible'];

// querin gjithmone e bejme pasi bejme validimet
$query = "UPDATE menu SET";
$query.= " menu_name='{$menu_name}', ";
$query.= "position={$position}, ";
$query.= "visible={$visible} ";
$query.= "WHERE id= {$id} ";
$query.= "LIMIT 1";


$result= mysqli_query($connection, $query);


// nese deshton merr vlere negative, kjo behet se po te ishte ==1,nese nuk ndryshojme vleren del failed
if($result && mysqli_affected_rows($connection)>=0) {
	
	$_SESSION["message"]= "Menu Updatet Succesfully";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php");

}else{
	$message = "Menu update Failed!"; 
}

} // end of post submit


}else{
	// ne rast se nuk na vjen nga posti, dmth vje nga GET
}

//..........................
$layout_context= "admin";
include("../includes/layouts/header.php");
?>

<div id="main">
	<div id="navigation">
<?php
echo navigation($current_menu,$current_page); // vendosim keto argumenta sepse keto jane te definuara me siper
?>
</div>

<div id="page">

<?php
if(!empty($message)) {
	echo "<div class=\"message\">".htmlentities($message)."</div>";
}

// s kemipse e bejme session sepse jemi te po i njejti script
echo form_errors($errors);
?>

<h2> Edit Menu: <?php echo htmlentities($current_menu["menu_name"]); ?></h2>
<form action="edit_menu.php?menu=<?php echo urlencode($current_menu["id"]); ?>" method="post">
<p>Menu name: 
<input type="text" name="menu_name" value="<?php echo htmlentities($current_menu["menu_name"]); ?>"/>
</p>
<p>Position
<select name="position">

<?php
$menu_result=query_menu_results(false);
$menu_count=mysqli_num_rows($menu_result);
 for($count=1; $count<=($menu_count); $count++) {
 	echo "<option value=\"{$count}\"";
 	if ($current_menu["position"]== $count){
 		echo " selected";
 	}
 	
 	echo ">{$count}</option>";
 }
?>
	
</select>
</p>
<p>Visible:
<input type="radio" name="visible" value="0" <?php if($current_menu["visible"]==0) {echo "checked";} ?>
/>No
&nbsp;
<input type="radio" name="visible" value="1" <?php if($current_menu["visible"]==1) {echo "checked";
} 
?>
/>Yes
</p>
<input type="submit" name="submit" value="Edit Menu"/>
</form>
<br>
<a href="manage_content.php">Cancel</a>
&nbsp;
&nbsp;
<a href="delete_menu.php?menu=<?php echo urlencode($current_menu["id"]); ?>" onclick="return confirm('Are you sure you want to delete this?');">Delete Menu</a>

	<?php
	
	
	?>
	</div>
			
</div>

<?php include("../includes/layouts/footer.php"); ?>