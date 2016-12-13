<div id="footer">@Copyright Endrit Gjeta <?php echo date('Y'); ?></div>
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/script.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>
  $(".content_container").css("min-height", $(window).height());


</script>

	
<?php

// 5.  Close db connection, fromthe footer
if (isset($connection)){   
mysqli_close($connection);
}
?>
	</body>

</html>
