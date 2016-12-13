<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
require_once("../includes/validation_functions.php");
confirm_logged_in_admin(); 

find_selected_page(); 

if(!$current_page){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("admin.php");
}
//.........................
//form processing
if (isset($_POST['submit'])){
// process the form

// 2. Perform database QUERY


// validations// i bejme qe ne fiillim sepse me pas do i ndryshojme vlerat
$required_fields = array("page_name", "position","visible","content"); //sifillim ivendosim ne POST ne array, me qellim validimin
validate_presences($required_fields);
$fields_with_max_lengths=array("page_name" => 30);
validate_max_lengths($fields_with_max_lengths);

if (empty($errors)){

// perform update
	$id= $current_page["id"];
	$page_name=  mysql_escape($_POST['page_name']);
	$position= (int) $_POST['position'];
	$visible= (int) $_POST['visible'];
	$content= mysql_escape($_POST['content']);
	$img_source =mysql_escape($_POST["img_source"]);
// querin gjithmone e bejme pasi bejme validimet
	$query = "UPDATE pages SET";
	$query.= " page_name='{$page_name}', ";
	$query.= "position={$position}, ";
	$query.= "visible={$visible}, ";
	$query.= "content='{$content}', ";
	$query.= "img_source='{$img_source}' ";
	$query.= "WHERE id= {$id} ";
	$query.= "LIMIT 1";


	$result= mysqli_query($connection, $query);


// nese deshton merr vlere negative, kjo behet se po te ishte ==1,nese nuk ndryshojme vleren del failed
	if ($result && mysqli_affected_rows($connection)>=0) {

$_SESSION["message"]= "Page Updatet Succesfully";//nuk kemi ku ti vendosim sepse eshte redirect
redirect_to("manage_content.php");

}else{
	$message = "Page update Failed!"; 
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

	<h2> Edit Page: <?php echo htmlentities($current_page["page_name"]); ?></h2>
	<form action="edit_page.php?pages=<?php echo urlencode($current_page["id"]); ?>" method="post">
		<p>Page name: 
			<input type="text" name="page_name" value="<?php echo htmlentities($current_page["page_name"]); ?>"/>
		</p>
		<p>Position
			<select name="position">

				<?php
				$page_result=query_pages_for_menu($current_page["menu_id"],false);
				$page_count=mysqli_num_rows($page_result);
				for($count=1; $count<=($page_count); $count++) {
					echo "<option value=\"{$count}\"";
					if ($current_page["position"]== $count){
						echo " selected";
					}
					
					echo ">{$count}</option>";
				}
				?>

			</select>
		</p>
		<p>Visible:
			<input type="radio" name="visible" value="0" <?php if($current_page["visible"]==0) {echo "checked";} ?>
			/>No
			&nbsp;
			<input type="radio" name="visible" value="1" <?php if($current_page["visible"]==1) {echo "checked";
		} 
		?>
		/>Yes
	</p>
	<p>IMG Source:
		<input type="text" name="img_source" value="<?php echo htmlentities($current_page["img_source"]); ?>" />
	</p>
	<p>Content:<br />
		<textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_page["content"])?> </textarea>
	</p>
	<input type="submit" name="submit" value="Edit Page"/>
</form>
<br>
<a href="manage_content.php">Cancel</a>
&nbsp;
&nbsp;
<a href="delete_page.php?pages=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure you want to delete this?');">Delete Page</a>

<?php


?>
</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>