<?php
// 1. create db connnection
$dbhost= "localhost";
$dbuser= "endrit";
$dbpass= "12345";
$dbname= "library";
$connection= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);


// 1.2. test if connected

if(mysqli_connect_errno()) {
	die ("Database connection failed:". "-".
		mysqli_connect_error(). "-".
		mysqli_connect_errno() );
}


// 2. Perform database QUERY

$query = "SELECT * ";
$query.= "FROM menu ";
$query.= "WHERE visible=1 ";
$query.= "ORDER BY position ASC ";

$result= mysqli_query($connection, $query);
if(!$result) {
	die("Database query failed.");
}


?>



<!DOCTYPE html>


	<head>
		<title> DB Steps</title>
	</head>

	<body>
<ul>
<?php	
// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
while($menu= mysqli_fetch_assoc($result)) {
	// output data from each row
?>
	
	<li><?php echo $menu["menu_name"]. "-". $menu["id"]; ?></li>
<?php	
}
?>	
</ul>


<?php

// fetch_row
//while($row= mysqli_fetch_row($result)) {
	// output data from each row
//	var_dump($row);
//	echo "<hr />";
//}
//fetch_array , (cando both row and assoc,slower)
//while($row= mysqli_fetch_array($result)) {
	// output data from each row
//	var_dump($row);
//	echo "<hr />";
//}

//fetch_object , (ob oriented,slower)



// 4. Release the returned data
mysqli_free_result($result);

		
?>

	</body>

</html>

<?php
// 5.  Close db connection
mysqli_close($connection);

?>