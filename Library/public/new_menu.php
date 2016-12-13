<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in_admin(); 
$layout_context= "admin"; 
include("../includes/layouts/header.php");
?>

<?php  find_selected_page();  ?>

<div id="main">
	<div id="navigation">
<?php
echo navigation($current_menu,$current_page); // vendosim keto argumenta sepse keto jane te definuara me siper
?>
</div>

<div id="page">

<?php
echo message();

$errors=errors(); // e kemi ruajtur si session to create_menu.php
echo form_errors($errors);
?>

<h2> Create Menu</h2>
<form action="create_menu.php" method="post">
<p>Menu name: 
<input type="text" name="menu_name" value=""/>
</p>
<p>Position
<select name="position">

<?php
$menu_result=query_menu_results(false);
$menu_count=mysqli_num_rows($menu_result);
 for($count=1; $count<=($menu_count+1); $count++) {
 	echo "<option value=\"{$count}\">{$count}</option>";
 }
?>
	
</select>
</p>
<p>Visible:
<input type="radio" name="visible" value="0"/>No 
&nbsp;
<input type="radio" name="visible" value="1"/>Yes
</p>
<input type="submit" name="submit" value="Create Menu"/>
</form>
<br>
<a href="manage_content.php">Cancel</a>

	<?php
	
	
	?>
	</div>
			
</div>

<?php include("../includes/layouts/footer.php"); ?>