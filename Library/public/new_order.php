<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
$layout_context= "public"; 
confirm_logged_in_user(); 



if (isset($_GET['id'])){

  $book_id= (int)$_GET['id'];
  
  $query  = "INSERT INTO user_books(";
  $query .= "  user_id, book_id, quantity, date ";
  $query .= ") VALUES (" ;
  $query .= " {$_SESSION['user_id']}, {$book_id} , 1, now() ";
  $query .= ")";
  $result = mysqli_query($connection, $query);
  confirm_query($result);
  mysqli_free_result($result);

  $update= "UPDATE books SET ";
  $update.= "quantity = quantity-1 ";
  $update.= "LIMIT 1";
  $result_update = mysqli_query($connection, $update);
  confirm_query($result_update);

  if (($result) && ($result_update)) {
// Success
    $_SESSION["message"] = "Order completed!";
    redirect_to("user_account.php");

  } else {

// Failure
    $_SESSION["message"] = "Order not completed!";
  }
  mysqli_free_result($result);
  
}
?>