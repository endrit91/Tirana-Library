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


            <h1>Welcome: <?php echo ucfirst($_SESSION["username"]); ?></h1>
            <?php

           
                  echo message(); 
                  echo form_errors($errors); 
                if ($current_page && $current_menu){
                echo "<h4>". htmlentities($current_page["page_name"]). "<br></h4>";

                echo nl2br(htmlentities($current_page["content"])). "<br>"; 

                }elseif ($current_menu){
                  echo "<h4>". htmlentities($current_menu["menu_name"]). "<br></h4>";

           if ($current_menu["id"]==="1"){  // if this is books button menu

               include("../includes/layouts/show_all_books.php");

              }
                }else{
               } 
               ?>
                <!-- search form-->
                <h2 id="form_margin_top">Search for books</h2>
                <form action="#search_result" method="post">
                
                  <label> Search by:</label><br />
                  <select name="searchtype">
                    <option name="author" value="author">Author</option>
                    <option name="title" value="title">Title</option>
                  </select>
                  <br />
                  <label>Enter Search Term:</label><br />
                  <input type=”"text" name="searchterm" size="40"/>
                  <br />
                  <button type="submit" name="submit" value="Search" class="btn btn-info search_margin_top">Search</button>

                </form>
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
  <h1> About Tirana Library </h1>

</div>

</div>
<?php include("../includes/layouts/footer_public.php"); // here are also the closing tags ofbody and html  ?> 