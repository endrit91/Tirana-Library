  <?php
  require_once("../includes/sessions.php"); 
  require_once("../includes/db_connection.php"); 
  require_once("../includes/functions.php"); 
  require_once("../includes/validation_functions.php");
  $layout_context= "public"; 
  find_selected_page(true);  

  include("../includes/layouts/header_public.php"); // here is the begining of the page, like opening body tags and htlm, and navigation 
  ?>
  <div class="container content_container" id="top_container"> <!--vertical navigation div -->
    <div class="row">
      <div class="col-md-2" id="navigation">
        <?php
        echo public_navigation($current_menu,$current_page);
        ?>
             <!-- search form-->
              <h4 id="form_margin_top" class="center">Search for books</h4>
              <form action="#search_result" id="search_form" method="get" class="center">

                <label> Search by:</label><br />
                <select name="searchtype">
                  <option name="author" value="author">Author</option>
                  <option name="title" value="title">Title</option>
                </select>
                <br />
                <label>Enter Search Term:</label><br />
                <input type=”"text" name="searchterm" size="25"/>
                <br />
                <button type="submit" name="submit" value="Search" class="btn btn-info search_margin_top">Search</button>

              </form>
      </div>

      <div class="col-md-8 col-md-offset-center" id="top_row">
        <?php
        echo message(); 
        echo form_errors($errors); 
        if ($current_page && $current_menu){
          echo "<h4>". htmlentities($current_page["page_name"]). "<br></h4>";

          echo nl2br(htmlentities($current_page["content"])). "<br>"; 

        }elseif ($current_menu){
          echo "<h4>". htmlentities($current_menu["menu_name"]). "<br></h4>";

             if ($current_menu["position"]==="1"){  // if this is books button menu

               include("../includes/layouts/show_all_books.php");
             }
           }elseif ($current_page){
          echo "<h4>". htmlentities($current_page["page_name"]). "<br></h4>";
          echo nl2br(htmlentities($current_page["content"])). "<br>";
           }else{
            ?>
            <div class="statement_block">
              <h1 class="statement">Find your inner peace</h1>
              <p class="lead"> Please sign in or create an account in the button below in order to purchase the book you like<p>
                <a href="new_user.php"><button type="button" class="btn btn-success">Sign Up</button></a>
             </div>
                <?php } ?>
            
            </div>

            <div class="col-md-2"> <!--right social div -->


            </div>

          </div>

        </div>
      </div> <!-- end of first page container, begining is in header_public.php-->
      <div class="container content_container center"> 
       
     
     <div class="row">
      <div id="results" class="col-md-12">
      Perfundime
      </div>
       <div class="col-md-2">
       </div>
       <div class="col-md-8">
        <?php include("../includes/layouts/search.php"); ?>
        <?php 
        $page=find_invisible_page();

        ?>
        <h1><?php echo htmlentities($page['page_name']); ?></h1>
        <img src="<?php echo htmlentities($page['img_source']); ?>"></img>
        <p><?php echo nl2br(htmlentities($page['content'])); ?></p>
        <?php            
        
        ?>
      </div>
      <div class="col-md-2">
      </div>
    </div>

  </div>
  </div>
  <?php include("../includes/layouts/footer_public.php"); // here are also the closing tags ofbody and html  ?> 
