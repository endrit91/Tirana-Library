<?php // ketu bejme procesimin me databasen
require_once("../includes/sessions.php"); 

require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in();
require_once("../includes/validation_functions.php");
?>


<html>
<head>
<title>Search results</title>
</head>
<body>
<h1>Search Results</h1>
<?php


if (isset($_POST['submit'])){
	// create variable names
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

$query="SELECT authors.author, books.title, books.price
FROM books
JOIN authorsbooks on books.id = authorsbooks.bookid
JOIN authors on authorsbooks.authorid = authors.id
WHERE ".$searchtype." like '%".$searchterm."%'";

$result= mysqli_query($connection, $query);
confirm_query($result);

$num_results= mysqli_num_rows($result);
echo "<p>Number of books found: ".$num_results."</p>";
for ($i=0; $i < $num_results; $i++) {
$row = mysqli_fetch_assoc($result);
echo "<p><strong>".($i+1).". Title: ";
echo htmlspecialchars(stripslashes($row['title']));
echo "<br />Author: ";
echo htmlspecialchars(stripslashes($row['author']));
echo "<br />Price: ";
echo stripslashes($row['price']);
echo "</p>";
}

mysqli_free_result($result);
}else{

?>
<body>
<h1>Search for books</h1>
	<form action="results.php" method="post">
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
<?php } ?>
</body>
</html>



