<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
 $layout_context= "public"; 
include("../includes/layouts/header.php");
?>

<?php  find_selected_page(true);  ?>
<html>
<body>

<div id="main">
	<div id="navigation">

<?php
echo public_navigation($current_menu,$current_page); // vendosim keto argumenta sepse keto jane te definuara me siper
?>
</div>
<div id="page_public">

<?php
	if ($current_page){
	echo "<h2>". htmlentities($current_page["page_name"]). "</h2>";

	echo nl2br(htmlentities($current_page["content"])); // nl2br eshte new linee to <br>

	}else{
?> 
<p>Welcome!</p>

<?php
		
	}
?>

<?php

if (isset($_POST['submit'])){
		// create variable names
?> 
<h2>Search for books</h2>
	<form action="index.php" method="post">
	Search by:<br />
	<select name="searchtype">
	<option name="author" value="author">Author</option>
	<option name="title" value="title">Title</option>
	</select>
	<br />
	Enter Search Term:<br />
	<input type=”"text" name="searchterm" size="40"/>
	<br />
	<input type="submit" name="submit" value="Search"/>
	</form>
<?php
$searchtype = $_POST['searchtype'];
$searchterm = trim($_POST['searchterm']);
if (!$searchtype || !$searchterm) {
echo 'You have not entered search details. Please go back and try again.';
exit;
}
if (!get_magic_quotes_gpc()){
$searchtype = addslashes($searchtype);
$searchterm = addslashes($searchterm);
}

//$query = "select * from books where ".$searchtype." like '%".$searchterm."%'";
echo "<h3>Search Results</h3>";
$query="SELECT authors.author, books.title, books.price
FROM books
JOIN authorsbooks on books.id = authorsbooks.book_id
JOIN authors on authorsbooks.author_id = authors.id
WHERE ".$searchtype." like '%".$searchterm."%'";

$result= mysqli_query($connection, $query);
confirm_query($result);

$num_results= mysqli_num_rows($result);

echo "<p>Number of books found: ".$num_results."</p>";
for ($i=0; $i < $num_results; $i++) {
$row = mysqli_fetch_assoc($result);
?>
 <table class="table table-hover">
  <thead>
      <tr>
        <th>Number</th>
        <th>Book Title</th>
        <th>Author</th>
        <th>Price</th>
      </tr>
  </thead>
<tbody>
<tr>
<td>
 <?php
echo " <p><strong>".($i+1); 
?> 
</td>

<td>
<?php
echo htmlspecialchars(stripslashes($row['title']));
?></td>
<td>
<?php
echo htmlspecialchars(stripslashes($row['author']));
?>
</td>
<td>
<?php
echo stripslashes($row['price']);
echo "</p>";
}
?>

</td>
</tr>
   </tbody>
</table>
<?php
mysqli_free_result($result);
 

}else{

?>

<h2>Search for books</h2>
	<form action="index.php" method="post">
	Search by:<br />
	<select name="searchtype">
	<option name="author" value="author">Author</option>
	<option name="title" value="title">Title</option>
	</select>
	<br />
	Enter Search Term:<br />
	<input type=”"text" name="searchterm" size="40"/>
	<br />
	<input type="submit" name="submit" value="Search"/>
	</form>

<?php } 


?>
	</div>

	
</div>
</body>
</html>
<?php include("../includes/layouts/footer.php"); ?>
