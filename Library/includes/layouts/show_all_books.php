   
	<table class="table table-hover table_style">
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
              
                  $result= find_all_books();

                  $num_results= mysqli_num_rows($result);

                  echo "<h4 class=\"center\">Number of books: ".$num_results."</h4>";



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

                 <?php if(!isset($_SESSION['user_id'])) { ?>   
              <a href="javascript:onclick()"><button type="button" class="btn btn-sm btn-warning" onclick="alert('Please login or sign up to create an account first!');">Order Now</button></a> 
              <?php } else{ ?>

              
              <a href="new_order.php?id=<?php echo urlencode($row["id"]);?>" ><button type="submit" name="order" class="btn btn-sm btn-warning">Order Now</button></a>
                           
<?php } ?>
                      </td>
                      <?php
                        }
                    ?>
                  </tr>
                </tbody>
              </table>
              <?php
              mysqli_free_result($result);

       

            



