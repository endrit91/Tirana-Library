
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Tirana Library</title>

  <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/public.css" media="all">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      
    </head>
    <body>

      <nav class="navbar navbar-default navbar-fixed-top">
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
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="#about">About</a></li>
            </ul>

            <?php if (!isset($_SESSION['user_id'])) { ?>
            <form action="index.php" method="post" class="navbar-form navbar-right">
              <div class="form-group">
                <input type="text" name="username" placeholder="Username" class="form-control">
                <input type="password" name="password" placeholder="Password" class="form-control">
              </div>
              <button type="submit" name="login" class="btn btn-succes">Log In</button>
            </form>
            <?php
            $username= "";

            if (isset($_POST['login'])) {
  // Process the form

  // validations
              $required_fields = array("username", "password");
              validate_presences($required_fields);
              $fields_with_max_lengths=array("username"=>30);
              validate_max_lengths($fields_with_max_lengths);

              if (empty($errors)) {
    // Attempt Login
                $username= $_POST["username"];
                $password= $_POST["password"];

                $found_user=attempt_login($username, $password);

                if ($found_user){
  //Success.
                  $_SESSION["user_id"]=$found_user["id"];
                  $_SESSION["username"]=$found_user["username"];
                  $_SESSION["is_admin"]=$found_user["is_admin"];
                  if($found_user["is_admin"]==="1") {
                    redirect_to("admin.php");
                  } elseif ($found_user["is_admin"]==="0") {
                    redirect_to("index_user.php");

                  }

                } else {

      // Failure
                  $_SESSION["message"] = "Username/password not found!";
                }
              }
            } else {
  // This is probably a GET request

            } 
          }else{
            ?>
            <div class="btn-group navbar-right">
                  <a href="user_account.php"><button type="button" class="btn btn-info btn-sm my_account_button">
                  <span class="glyphicon glyphicon-user"></span> My Account 
                  </button></a>
                  <a href="logout.php"><button type="button" class="btn btn-default btn-sm  log_button">
                  <span class="glyphicon glyphicon-log-out"></span> Log out </button></a> 
           </div>
           
           <?php
          }


        ?>


          </div>
        </nav>
            
     