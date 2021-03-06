<?php
require_once("../includes/sessions.php"); 

require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
 ?>



<?php
$username= "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  $fields_with_max_lengths=array("username"=>40);
  validate_max_lengths($fields_with_max_lengths);
  
if (empty($errors)) {
    // Attempt Login
$username= $_POST["username"];
$password= $_POST["password"];

$found_user=attempt_login_user($username, $password);
   
 if ($found_user){
  //Success.
  $_SESSION["user_id"]=$found_user["id"];
  $_SESSION["username"]=$found_user["username"];
      redirect_to("index.php");
    } else {
    	
      // Failure
      $_SESSION["message"] = "Username/password not found!";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>
<?php $layout_context= "admin"; // do e bejme user?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
   
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Login</h2>
    <form action="user_login.php" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" />
       </p> 
      <input type="submit" name="submit" value="Submit" />
    </form>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
