<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php 
    $selected_subject_id = null;
	$selected_page_id = null;
	if (isset($_GET["subject"])) {
		$selected_subject_id = $_GET["subject"];
	} elseif (isset($_GET["page"])) {
		$selected_page_id = $_GET["page"];
	} 
?>

<div id="main">
	<div id="navigation">
	<?php echo navigation($selected_subject_id, $selected_page_id); ?>
	
	</div>
	<div id="page">
		<h2>Manage Content</h2>
		<p> Welcome to the Manage Content area.</p>
		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="Logout.php">Logout</a></li>
			<?php 
			echo  "  subject_id=". $selected_subject_id;
            echo  " page_id=".	 $selected_page_id;
			?>
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>