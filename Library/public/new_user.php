<?php
require_once("../includes/sessions.php"); 

require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
//confirm_logged_in();
require_once("../includes/validation_functions.php");
 ?>



<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username","password", "password_1");
  validate_presences($required_fields);
  $fields_with_max_lengths=array("username"=>40);
  validate_max_lengths($fields_with_max_lengths);
if ($_POST["password"]!==$_POST["password_1"]) {
    $_SESSION["message"]= "You probably typed different passwords";
  redirect_to("new_user.php");

}elseif (empty($errors))  {
    // Perform Create
   
    $username = mysql_escape($_POST["username"]);
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
  
    $query  = "INSERT INTO users (";
    $query .= "  username, password, is_admin ";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hashed_password}', 0 ";
    $query .= ")";
    $result = mysqli_query($connection, $query);
    


    if ($result) {
      // Success
      $_SESSION["message"] = "Sign up succesful.";
      redirect_to("login.php");
    } else {
    	
      // Failure
      $_SESSION["message"] = "Signup failed ";
    }
  }
} else {
  // This is probably a GET request
 
} // end: if (isset($_POST['submit']))

?>
<?php $layout_context= ""; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
   
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Sign Up</h2>
    <form action="new_user.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" />
       </p> 
       <p>Password:
        <input type="password" name="password_1" />
       </p> 
       
      <input type="submit" name="submit" value="Sign up" />
    </form>
    <br />
    <a href="index.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>