<?php if (!isset($layout_context)){
	$layout_context= "public"; 
	}
	?>
<!DOCTYPE html>


<head>
<link rel="stylesheet" type="text/css" href="css/public.css" media="all">
	<title>Library <?php if ($layout_context== "admin") {echo "Admin";} ?></title>

</head>

<body>
	<div id="header">
		<h1>Library <?php if ($layout_context== "admin") {echo "Admin";} ?></h1>
	</div>