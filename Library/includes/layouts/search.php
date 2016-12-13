<?php // vendosim kushtin

if (isset($_GET['submit'])){
  ?>
  <div id= "search_result">  
    <?php
    $searchtype = $_GET['searchtype'];
    $searchterm = trim($_GET['searchterm']);
    if (!$searchtype || !$searchterm) {
      echo $SESSION['error']='You have not entered search details. Please go back and try again.';
      exit;
    }
    if (!get_magic_quotes_gpc()){
      $searchtype = addslashes($searchtype);
      $searchterm = addslashes($searchterm);
    }
    //sleep(5);
//$query = "select * from books where ".$searchtype." like '%".$searchterm."%'";
    echo "<h3 class=\"center\">Search Results</h3>";
    $query="SELECT authors.author, books.title, books.price, books.quantity
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
          <th></th>
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
              ?>
            </td>
            <td>
              <?php if(!isset($_SESSION['user_id'])) { ?>   
              <a href="javascript:onclick()"><button type="button" class="btn btn-sm btn-warning" onclick="alert('Please login or sign up to create an account first!');">Order Now</button></a> 
              <?php } else { ?>

              
              <a href="new_order.php?id=<?php echo urlencode($row["id"]);?>" ><button type="submit" name="order" class="btn btn-sm btn-warning">Order Now</button></a>
                           
<?php } 
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
  