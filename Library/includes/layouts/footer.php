<div id="footer">@Copyright Endrit Gjeta <?php echo date('Y'); ?></div>
	<?php
// 5.  Close db connection, fromthe footer
if (isset($connection)){   
mysqli_close($connection);
}
?>
	</body>

</html>
