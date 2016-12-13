<?php
//require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
 $layout_context= "public"; 
//include("../includes/layouts/header.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
  #top_container {
    background-image: url("/Library/public/img/kzvmepyfijs-dustin-lee.jpg");
    width:100%;
    background-size: cover ;
    

      }

  #top_row{
    margin-top: 50px;
    text-align: center;
    font-size:;
  }
  #top_row h1{
    font-size: ;
  }
.search_margin_top{
  margin-top: 5px;
}
.center {
  text-align: center;
}
#form_margin_top {
margin-top: 100px;
}

</style>



  </head>
  <body>
    
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>         
          </button>
          <a class= "navbar-brand">Tirana Library</a>
        </div>

      <div class="collapse navbar-collapse">
        <ul class= "nav navbar-nav">
          <li class="active"><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
        </ul>
      <form class="navbar-form navbar-right">
        <div class="form-group">
        <input type="email" placeholder="Email" class="form-control">
        <input type="password" placeholder="Password" class="form-control">
        </div>
        <button type="submit class="btn btn-succes">Log In</button>
      </form>
      </div>
      </div>
    </div>

<div class="container content_container" id="top_container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3" id="top_row">
    <h1>Find your inner peace</h1>
    <p class="lead"> Please sign in or create an account in the button below in order to purchase the book you like<p>
    <button type="button" class="btn btn-success">Sign Up</button>

<!-- search form-->
<h2 id="form_margin_top">Search for books</h2>
      <form action="#search_result" method="post">
        Search by:<br />
        <select name="searchtype">
        <option name="author" value="author">Author</option>
        <option name="title" value="title">Title</option>
        </select>
        <br />
        Enter Search Term:<br />
        <input type=”"text" name="searchterm" size="40"/>
        <br />
        <button type="submit" name="submit" value="Search" class="btn btn-info search_margin_top">Search</button>

      </form>

  </div>
    </div>
    
  </div>
 </div> <!-- end of first page container-->
<div class="container">
<?php // vendosim kushtin

if (isset($_POST['submit'])){
?>
<div id= "search_result">  
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
echo "<h3 class=\"center\">Search Results</h3>";
$query="SELECT authors.author, books.title, books.price
FROM books
JOIN authorsbooks on books.id = authorsbooks.book_id
JOIN authors on authorsbooks.author_id = authors.id
WHERE ".$searchtype." like '%".$searchterm."%'";

$result= mysqli_query($connection, $query);
confirm_query($result);

$num_results= mysqli_num_rows($result);

echo "<p class=\"center\">Number of books found: ".$num_results."</p>";
?>

<table class="table table-hover">
  <thead>
      <tr>
        <th></th>
        <th>Book Title</th>
        <th>Author</th>
        <th>Price</th>
      </tr>
  </thead>
<tbody>


<?php
for ($i=0; $i < $num_results; $i++) {
$row = mysqli_fetch_assoc($result);
?>
 <tr>
<td>
 <?php
echo " <p><strong>".($i+1); 
?> 
</td>

<td>
<?php
echo htmlspecialchars(ucfirst(stripslashes($row['title'])));
?></td>
<td>
<?php
echo htmlspecialchars(stripslashes($row['author']));
?>
</td>
<td>
<?php
echo stripslashes($row['price']);
}
?>

</td>
</tr>
   </tbody>
</table>
<?php
mysqli_free_result($result);


}else{

} 


?>
  
</div>
  <div class="row">
    <h1> About Tirana Library </h1>

  </div>

</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $("#top_container").css("height", $(window).height());
     </script>
     <script>
    $(".content_container").css("min-height", $(window).height());
     </script>
  </body>
</html>