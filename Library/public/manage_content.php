<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in(); 
$layout_context= "admin"; 
include("../includes/layouts/header.php");
?>

<?php  find_selected_page();  ?>

<div id="main">
	<div id="navigation">
<br>
<a href="admin.php"> &laquo; Main Menu</a> <br>

<?php
echo navigation($current_menu,$current_page); // vendosim keto argumenta sepse keto jane te definuara me siper
?>
<br>
<a href="new_menu.php">+ Add a Menu</a>

</div>

<div id="page">

<?php
echo message();
?>
		
	<?php
	if($current_menu) {
		echo "<h2>". "Manage Menu" ."</h2>";
		echo htmlentities($current_menu["menu_name"]). "<br>";
		echo "Position:" .$current_menu["position"]. "<br>";
		?>
		Visible: <?php echo $current_menu["visible"] ==1 ? 'Yes': 'No'; ?>
		<br>
		<br>
		
		<a href="edit_menu.php?menu=<?php echo urlencode($current_menu["id"]); ?>">Edit Menu</a>

		<br>
		<hr class="line"/>

	

		
<?php 

	//.........................................
	echo "<h2>". "Pages in this Menu" ."</h2>";

	echo show_pages_by_menu($current_menu,$current_page);

	//...................................
		?>
		<br>
	<a href="new_page.php?menu=<?php echo urlencode($current_menu["id"]); ?>">+ Add a new Page to Menu</a>

<?php
	}elseif ($current_page){
		echo "<h2>". "Manage Page" ."</h2>";
		
		echo htmlentities($current_page["page_name"]). "<br>";
	
		echo "Position:" .$current_page["position"]. "<br>";
		?>
		Visible: <?php echo $current_page["visible"] ==1 ? 'Yes': 'No'; ?>
		<br>
		<br>
	Content: 
	<br>
	<div class="view-content">

	<?php	
	echo htmlentities($current_page["content"]);

	?>
	
	</div>
	<br>
	<br>

<a href="edit_page.php?pages=<?php echo urlencode($current_page["id"]); ?>"> Edit Page</a>

	<?php

	}else{
		echo "Please select a menu or page!";
	}
	
	?>
	</div>
			
</div>

<?php include("../includes/layouts/footer.php"); ?>

