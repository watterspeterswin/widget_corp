<div id="footer">Copyright <?php echo date("Y") ?>, Widget Corp</div>
</body>
</html>
<?php
if (isset($dblink)) {
	$dblink->close(); 
}
?>