<?php 
function redirect_to($new_page){
	header("Location:". $new_page);
	exit;
}
//.................................................

function mysql_escape($string){
	global $connection;
	$escaped_string=mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}



//...................................................................
function confirm_query($result_set){
if(!$result_set) {
	die("Database query failed.");
}
}
//...................................................
function form_errors($errors=array()){
	$output= "";
if (!empty($errors)) {
	$output="<div class=\"error\">";
	$output.= "Please fix the following errors:";
	
	$output.= "<ul>";

	foreach ($errors as $key => $error) {

		$output .= "<li>";
		$output .=htmlentities($error);
		$output .="</li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}
return $output;
}
//.....................................
// 2. Perform database QUERY
function query_menu_results($public=true){ // po ndertojme contxtion per publicvs admin
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
$query = "SELECT * ";
$query.= "FROM menu ";
if ($public){
$query.= "WHERE visible=1 ";
}
  // sepse jemi te paneli i adminit, duhet ti shohim te gjitha
$query.= "ORDER BY position ASC ";

$menu_result= mysqli_query($connection, $query);

confirm_query($menu_result);            // eshte te funksionet, tregon a ka deshtuar query
return $menu_result;
}

//...................................................
function query_pages_for_menu($menu_id, $public=true){
// 2. Perform database QUERY
global $connection;   
$query = "SELECT * ";  
          // jemi akoma brenda while loop, nese do ishim jashte nuk do njihej variabli $menu['id']
$query.= "FROM pages ";
//
//
$query.= "WHERE menu_id= {$menu_id} ";
if ($public){
$query.= "AND visible=1 ";	
}
// ketu i japimnje vlere fiktive ne menyre qe te mos jete array sepse eshte ne scope, ndersa te funksioni ijapim vleren e duhur
$query.= "ORDER BY position ASC";

$result_page= mysqli_query($connection, $query);

confirm_query($result_page);

return $result_page;
}

//...............................................

function navigation($menu_array,$page_array){
	// navigimi merr 2 argumente qe jane pjese e loop
	// keto argumente jane fiktive, prandaj i ndyshojme edhe me poshte, mund te vendosnim edhe global po eshte me mire keshtu, ndersa tek deklarimi i funksionit e vendosim me argumentin e duhur

	$output="<ul class=\"menu\">";

$menu_result=query_menu_results(false);

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
while($menu= mysqli_fetch_assoc($menu_result)) {
	// output data from each row

	$output.= "<li class=\"button\"";
	if ($menu_array && $menu["id"]==$menu_array["id"]) {
	$output.= " class=\"selected\"";
}
$output.= ">";

$output.="<a href=\"manage_content.php?menu=";
$output.= urlencode($menu["id"]); 
$output.="\">";
$output.= htmlentities($menu["menu_name"]); 
$output.="</a>";

//......fillon pages-------------------------------

$result_page=query_pages_for_menu($menu["id"],false); // query i dyte
$output.="<ul class=\"pages\">";

while($pages= mysqli_fetch_assoc($result_page)) {
	// loop per pages
	
	$output.= "<li";
		if ($page_array && $pages["id"]==$page_array["id"]) {
		$output.= " class=\"selected\"";
	}
	$output.= ">";
	
$output.="<a href=\"manage_content.php?pages=";
$output.= urlencode($pages["id"]); 
$output.="\">";
$output.= htmlentities($pages["page_name"]); 
$output.="</a></li>";
	
}
mysqli_free_result($result_page);


$output.="</ul>";
$output.="</li>";


}
mysqli_free_result($menu_result);

$output.="</ul>";
return $output;

}

//..........................................................................................................................
function show_pages_by_menu($menu_array,$page_array){ // 

//......fillon pages-------------------------------

if ($menu_array){
$result_page=query_pages_for_menu($menu_array["id"]); // query i dyte
$output="<ul class=\"pages\">";

while($pages= mysqli_fetch_assoc($result_page)) {

	// loop per pages
	
	$output.= "<li>";
	
$output.="<a href=\"manage_content.php?pages=";
$output.= urlencode($pages["id"]); 
$output.="\">";
$output.= htmlentities($pages["page_name"]); 
$output.="</a></li>";
	
}
mysqli_free_result($result_page);
$output.="</ul>";
}

return $output;
}

//.................................................

function show_pages_by_menu_query($menu_array,$page_array){ // 

if ($menu_array){
$result_page=query_pages_for_menu($menu_array["id"]);
return $result_page;
}
}

//''''''''''''''''''''''''''''''''''''''''''''''''

function find_menu_by_id($menu_id,$public=true){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_menu_id= mysqli_real_escape_string($connection,$menu_id);
	$query = "SELECT * ";
	$query.= "FROM menu ";
	$query.= "WHERE id={$safe_menu_id} ";
	if ($public) {
	$query .= "AND visible= 1 ";
}

	$query.= "LIMIT 1";

	$menu_result= mysqli_query($connection, $query);

	confirm_query($menu_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($menu=mysqli_fetch_assoc($menu_result)){// e bejme qe ketu te funksioni asociimin meqe kemi vetem 1 rezultat, per efekt lehtesie
		return $menu; 
	}else{
		$return=null;
	}
}
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
function find_page_by_id($page_id, $public=true){
// 2. Perform database QUERY
	global $connection;
$safe_page_id= mysqli_real_escape_string($connection,$page_id);
   
$query = "SELECT * ";  
          // jemi akoma brenda while loop, nese do ishim jashte nuk do njihej variabli $menu['id']
$query.= "FROM pages ";
$query.= "WHERE id= {$safe_page_id} ";
if ($public) {
	$query .= "AND visible= 1 ";
}
// ketu i japimnje vlere fiktive ne menyre qe te mos jete array sepse eshte ne scope, ndersa te funksioni ijapim vleren e duhur
$query.= "LIMIT 1";

$page_result= mysqli_query($connection, $query);

confirm_query($page_result);

if($page=mysqli_fetch_assoc($page_result)){
	return $page;
} else{
	return null;
}
}
/////.................................................................
function find_default_page_for_menu($menu_id){
	$page_result=query_pages_for_menu($menu_id);
	if($first_page=mysqli_fetch_assoc($page_result)){
		return $first_page;
	}else{
		return null;
	}
}


//
//..................................
function find_selected_page($public=false){

global $current_menu;
global $current_page;

if (isset($_GET["menu"])){
	$current_menu=find_menu_by_id($_GET["menu"],$public);
	if($current_menu && $public){
	$current_page=find_default_page_for_menu($current_menu["id"]);	
}else{
	$current_page=null;
}
	
} elseif (isset($_GET["pages"])){

$current_page=find_page_by_id($_GET["pages"], $public);
$current_menu=null;
} else { //sepse kur vjen nga admin.php nuk eshte e definuar
	$current_menu=null;
	$current_page=null;
}
}

//....................................................................................................................
function public_navigation($menu_array,$page_array){
	// navigimi merr 2 argumente qe jane pjese e loop
	// keto argumente jane fiktive, prandaj i ndyshojme edhe me poshte, mund te vendosnim edhe global po eshte me mire keshtu, ndersa tek deklarimi i funksionit e vendosim me argumentin e duhur

	$output="<ul class=\"menu\">";

$menu_result=query_menu_results();

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
while($menu= mysqli_fetch_assoc($menu_result)) {
	// output data from each row

	$output.= "<li";
	if ($menu_array && $menu["id"]==$menu_array["id"]) {
	$output.= " class=\"selected\"";
}
$output.= ">";

$output.="<a href=\"index.php?menu=";
$output.= urlencode($menu["id"]); 
$output.="\">";
$output.= htmlentities($menu["menu_name"]); 
$output.="</a>";

//......fillon pages-------------------------------

if ($menu_array["id"]==$menu["id"] || $page_array["menu_id"]==$menu["id"] ){ // pra nese eshte klikuar nje menu ose faqet e asaj menuse shfaqen dhe vazhdojne te shfaqen faqe

	$result_page=query_pages_for_menu($menu["id"]); // query i dyte
	$output.="<ul class=\"pages\">";

	while($pages= mysqli_fetch_assoc($result_page)) {
		// loop per pages
		
		$output.= "<li";
			if ($page_array && $pages["id"]==$page_array["id"]) {
			$output.= " class=\"selected\"";
		}
		$output.= ">";
		
	$output.="<a href=\"index.php?pages=";
	$output.= urlencode($pages["id"]); 
	$output.="\">";
	$output.= htmlentities($pages["page_name"]); 
	$output.="</a></li>"; // fundi i pages
		
	}
	$output.="</ul>"; // fundi i pages
	mysqli_free_result($result_page);
}


$output.="</li>"; // fundi i menuse


}
mysqli_free_result($menu_result);

$output.="</ul>"; // fundi imenuse
return $output;

}

//.........................................................................................................................................

function query_all_admins(){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
$query = "SELECT * ";
$query.= "FROM admins ";
$query.= "ORDER BY username ASC ";

$admins_result= mysqli_query($connection, $query);

confirm_query($admins_result);            // eshte te funksionet, tregon a ka deshtuar query
return $admins_result;
}
//................................

function show_all_admins(){
	$admins_result= query_all_admins();

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
while($admins= mysqli_fetch_assoc($admins_result)) {
	// output data from each row
$output= htmlentities($admins["username"]); 
$output.= "<br>";
return $output;
}
}
//...........................................................

function find_admin_by_id($admin_id){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_admin_id= mysqli_real_escape_string($connection,$admin_id);
	$query = "SELECT * ";
	$query.= "FROM admins ";
	$query.= "WHERE id={$safe_admin_id} ";
	$query.= "LIMIT 1";

	$admin_result= mysqli_query($connection, $query);

	confirm_query($admin_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($admin=mysqli_fetch_assoc($admin_result)) {
		return $admin; 
	}else{
		return null;
	}
}
//.............................................................................................

function password_encrypt($password){


$hash_format= "$2y$10$"; // 2y do te thote blowfish dhe 10-> sa here perseritetalgoritmi pra 10 here
$salt_length= 22; //Blowfish salt i do 22 karaktereose mme shume
$salt= generate_salt($salt_length);
$format_and_salt = $hash_format . $salt;
$hash= crypt($password, $format_and_salt);

return $hash;
}

///,,,,,,,,,,,,,,,,,,,,,,,,,,,

function generate_salt($length){

	// md5 ka 35 karaktere
	$unique_random_string=md5(uniqid(mt_rand(), true));

	// valid characters for a salt {a-z A-Z 0-9 ./}
	$base64_string= base64_encode($unique_random_string);
	// zevendesojme '+' me '-' per saltin

	$modified_base64_string=str_replace('+', '.', $base64_string);

	// truncate string to the correct length
	$salt=substr($modified_base64_string, 0, $length);
	return $salt;

}

////...,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

function password_check($password, $existing_hash) {
//existing hash ka formatin salt qe ne fillim
$hash= crypt($password, $existing_hash);
if ($hash===$existing_hash) {
	return true;
} else {
	return false;
}
}
//................................................................///
function find_admin_by_username($username){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_username= mysqli_real_escape_string($connection,$username);
	$query = "SELECT * ";
	$query.= "FROM admins ";
	$query.= "WHERE username='{$safe_username}' ";
	$query.= "LIMIT 1";

	$admin_result= mysqli_query($connection, $query);

	confirm_query($admin_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($admin=mysqli_fetch_assoc($admin_result)) {
		return $admin; 
	}else{
		return null;
	}
}
///.............................................



function attempt_login($username, $password){
	$admin= find_admin_by_username($username);
	if($admin){
		// admin found // now check password
	if(password_check($password, $admin["password"])) {//$admin["password vjen nga databaza"]
		// pra nese jane identik
		return $admin;
}else{
	//password does not match
	return false;
}

}else{
		return false;
}
}
///,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
function logged_in(){

	return isset($_SESSION['admin_id']);
}
// kjo behet per ato faqe qe nuk jane admin por u duhen atribute te vecanta si perdorues, perdoret bashke me funksionin poshte
//................................................

function confirm_logged_in() {
if (!logged_in()) {

	redirect_to("login.php");
}
}







?>




