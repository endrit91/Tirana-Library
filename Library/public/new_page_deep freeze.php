<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
include("../includes/layouts/header.php");
require_once("../includes/validation_functions.php");
?>

<?php  find_selected_page(); 

  // Can't add a new page unless we have a subject as a parent!
  if (!$current_subject) {
    // subject ID was missing or invalid or 
    // subject couldn't be found in database
    redirect_to("manage_content.php");
  }
?>
<?php

	if (isset($_POST['submit'])){
// validations
	$required_fields = array("page_name", "position","visible","content"); //sifillim ivendosim ne POST ne array, me qellim validimin
	validate_presences($required_fields);
	$fields_with_max_lengths=array("menu_name" => 30);
	$fields_with_max_lengths=array("content" => 10000);
	validate_max_lengths($fields_with_max_lengths);

 if (empty($errors)){
// 2. Perform database QUERY
	$page_name=  mysql_escape($_POST['page_name']);
	$position= (int) $_POST['position'];
	$visible= (int) $_POST['visible'];
	$content= mysql_escape($_POST['content']);
	$menu_id= $current_menu["id"]; // kete e vendosim sepseeshte foreing key

	// querin gjithmone e bejme pasi bejme validimet
	$query = "INSERT INTO pages (";
	$query.= " page_name,position,visible,content,menu_id";
	$query.= ") VALUES (";

	$query.= " '{$page_name}', {$position}, {$visible},'{$content}',{$menu_id}";
	$query.= ")";

	$result= mysqli_query($connection, $query);


if($result) {
	
	$_SESSION["message"]= "Page creation Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_content.php?menu=". urlencode($current_menu["id"]));

}else{
	$_SESSION["message"] = "Page Creation Failed!";
}
}
}else{
	// ne rast se nuk na vjen nga posti, dmth vje nga GET
}

include("../includes/layouts/footer.php"); 


?>
<div id="main">
	<div id="navigation">
<?php
echo navigation($current_menu,$current_page); // vendosim keto argumenta sepse keto jane te definuara me siper
?>
</div>

<div id="page">

<?php
echo message();

//$errors=errors(); // nuk kemi nevoje per session meq te dy proceset i kemi ne nje form
echo form_errors($errors);
?>

<h2> Create Page</h2>
<form action="new_page.php?menu=<?php echo urlencode($current_menu["id"]); ?>" method="post">
<p>Page name: 
<input type="text" name="page_name" value=""/>
</p>
<p>Position
<select name="position">

<?php
if ($current_menu){
	$result_page=show_pages_by_menu_query($current_menu,$current_page);
$page_count=mysqli_num_rows($result_page);
 for($count=1; $count<=($page_count+1); $count++) {
 	echo "<option value=\"{$count}\">{$count}</option>";
 }
}
?>
	
</select>
</p>
<p>Visible:
<input type="radio" name="visible" value="0"/>No 
&nbsp;
<input type="radio" name="visible" value="1"/>Yes
</p>
<p>
Content:
<br>
<textarea name="content" rows="25" cols="80"></textarea>
</p>
<input type="submit" name="submit" value="Create Page"/>
</form>
<br>
<a href="manage_content.php?menu=<?php echo urlencode($current_menu["id"]); ?>">Cancel</a>
	</div>
			
</div>













	
