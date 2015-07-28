<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
	<?php echo navigation($current_subject, $current_page); ?>
	<br />
	<a href="new_subject.php">+ Add a subject</a>
	</div>
	<div id="page">
		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="Logout.php">Logout</a></li>

			<?php 
			if ($current_subject) { 
			    echo "<h2>Manage Subject</h2>";
				echo $current_subject["menu_name"];
			}
			elseif ($current_page) {
				echo "<h2>Manage Page</h2>";
				echo $current_page["content"];
			}
			else {
				echo "Please select a subject or page";
			}
			?> 
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>