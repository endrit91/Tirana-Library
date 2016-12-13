<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
$layout_context= "public"; 
confirm_logged_in_user(); 

if (isset($_GET['id'])){

  $book_id= (int)$_GET['id'];
  
  $query  = "DELETE FROM user_books
    WHERE 
   user_id={$_SESSION['user_id']} AND  book_id = {$book_id}
   LIMIT 1
    ";
  $result = mysqli_query($connection, $query);
  confirm_query($result);
  mysqli_free_result($result);

  $update= "UPDATE books SET ";
  $update.= "quantity = quantity+1 ";
  $update.= "LIMIT 1";
  $result_update = mysqli_query($connection, $update);
  confirm_query($result_update);

  if (($result) && ($result_update)) {
// Success
    $_SESSION["message"] = "Order cancelation Successfull!.";
    redirect_to("user_account.php");

  } else {

// Failure
    $_SESSION["message"] = "Order cancelation Failed!";
  }
  mysqli_free_result($result);
  
}
?>