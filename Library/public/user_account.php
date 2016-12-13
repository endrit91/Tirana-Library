<?php
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
require_once("../includes/validation_functions.php");
$layout_context= "public"; 
find_selected_page(true);  
confirm_logged_in_user(); 
include("../includes/layouts/header_public.php"); // here is the begining of the page, like opening body tags and htlm, and navigation 

?> 
<div class="container content_container" id="top_container"> <!--vertical navigation div -->
  <div class="row">
    <div class="col-md-2" id="navigation">

      <?php
      echo public_navigation($current_menu,$current_page);
      ?>
    </div>
    <div class="col-md-8 col-md-offset-center" id="top_row">
<?php
      echo message(); 
      echo form_errors($errors);
?>
      <h2>Hello: <?php echo ucfirst($_SESSION["username"]); ?></h2>

      <h4>Your Orders history:</h4>
      <table class="table table-hover table_style">
        <thead>
          <tr>
            <th></th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <?php
          $query="SELECT authors.author, books.title, books.price, user_books.date, books.id
          FROM books
          JOIN authorsbooks on books.id = authorsbooks.book_id
          JOIN authors on authorsbooks.author_id = authors.id
          JOIN user_books on books.id = user_books.book_id
          JOIN users on users.id = user_books.user_id

          WHERE users.id = {$_SESSION["user_id"]}
          ORDER BY user_books.date ";


          $result= mysqli_query($connection, $query);
          confirm_query($result);

          $num_results= mysqli_num_rows($result);

          echo "<h4 class=\"center\">Number of orders: ".$num_results."</h4>";



          for ($i=0; $i < $num_results; $i++) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <tr>
              <td>
               <?php
               echo " <p><strong>".($i+1); 
               ?>
             </p>
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
              ?>
            </td>
            <td>
              <?php
              echo htmlspecialchars(ucfirst(stripslashes($row['date'])));
            
            ?></td>
            <td>
              <a href="delete_order.php?id=<?php echo urlencode($row["id"]);?>" ><button type="submit" name="order" class="btn btn-xs btn-danger">Cancel Order</button></a>
            </td>
            <?php
            }
            ?>
          </tr>
        </tbody>
      </table>
      <?php
      mysqli_free_result($result);
      ?> 
    </div>

    <div class="col-md-2"> <!--right social div -->

    </div>

  </div>

</div>
</div> <!-- end of first page container, begining is in header_public.php-->
<div class="container"> 
 <?php include("../includes/layouts/search.php"); ?>
</div>
<div class="row">

</div>

</div>
<?php include("../includes/layouts/footer_public.php"); 