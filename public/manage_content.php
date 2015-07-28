<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php 
    $selected_subject_id = null;
	$selected_page_id = null;
	$current_subject = null;
	$current_page = null;
	
	if (isset($_GET["subject"])) {
		$selected_subject_id = $_GET["subject"];
		$current_subject =  find_subject_by_id($selected_subject_id);
	} elseif (isset($_GET["page"])) {
		$selected_page_id = $_GET["page"];
		$current_page =  find_page_by_id($selected_page_id);
	} 
?>

<div id="main">
	<div id="navigation">
	<?php echo navigation($selected_subject_id, $selected_page_id); ?>
	
	</div>
	<div id="page">


		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="Logout.php">Logout</a></li>

			<?php 
			if (isset($selected_subject_id)) { 
			    echo "<h2>Manage Subject</h2>";
				if($current_subject) {
					echo $current_subject["menu_name"];
				}
			}
			elseif (isset($selected_page_id)) {
				echo "<h2>Manage Page</h2>";
				if($current_page) {
					echo $current_page["content"];
				}
			}
			else {
				echo "Please select a subject or page";
			}
			?> 
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>