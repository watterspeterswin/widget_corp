<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
	<?php echo navigation($current_subject, $current_page); ?>
	</div>
	<div id="page">
		<h2></h2>
        <form action="create_subject.php" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
			<select name="position">
			    <option value="1">1</option>
			</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" />
				<input type="radio" name="visible" value="1" />
			</p>
			<input type="submit" name="Create Subject" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>