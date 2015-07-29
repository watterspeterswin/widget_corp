<?php

function redirect_to($new_location) {
	header("Location: ". $new_location);
	exit;
}

function GetConnection() 
{
	define("DB_USER", "root");
	define("DB_HOST","localhost");
	define("DB_PASSWORD","root");
	define("DB_DBNAME","widgets");
	$dblink=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DBNAME);
	if (mysqli_connect_errno()) {
		die("Database connection failed: ". 
		     mysqli_connect_error() .
			 " (" . mysqli_connect_errno() . ")"
		);
	}
	return $dblink;
}


function mysql_prep($instring) {
	
	global $dblink;
	
	$instring = $dblink->real_escape_string($instring);
	
	return $instring;
}

function confirm_query($result) {
	if (!$result) {
		die("database query failed");
	}
}

function get_subject_count() {
	
    global $dblink;
	
	$query  = "SELECT count(*) as subject_count ";
	$query .= "FROM subjects ";

	$subject_set = $dblink->query($query);
	confirm_query($subject_set);
    $subject_count = $subject_set->fetch_assoc();
	
	return $subject_count["subject_count"];
}


function find_all_subjects() {
	
    global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible ";
	$query .= "ORDER BY position";

	$subject_set = $dblink->query($query);
	confirm_query($subject_set);
		
	return $subject_set;
}

function find_pages_for_subject($subject_id) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE visible AND subject_id = {$subject_id} ";
	$query .= "ORDER BY position";

	$page_result = $dblink->query($query);
	confirm_query($page_result);
	
	return $page_result;
}

function find_page_by_id($page_id) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE id = {$page_id} ";
	$query .= "ORDER BY position";

	$page_result = $dblink->query($query);
	confirm_query($page_result);
	
	if ($page = $page_result->fetch_assoc()) {
		return $page;
	}
	else {
		return null;
	}
}

function find_subject_by_id($subject_id) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id = {$subject_id} ";
	$query .= "ORDER BY position";

	$subject_result = $dblink->query($query);
	confirm_query($subject_result);
	
	if ($subject = $subject_result->fetch_assoc()) {
		return $subject;
	}
	else {
		return null;
	}
}

function find_selected_page() {
	
	global $current_subject;
	global $current_page;
	$current_subject = null;
	$current_page = null;
	
	if (isset($_GET["subject"])) {
		$current_subject =  find_subject_by_id($_GET["subject"]);
	} elseif (isset($_GET["page"])) {
		$current_page =  find_page_by_id($_GET["page"]);
	} 
}

function navigation($p_subject, $p_page) {

	$subject_set = find_all_subjects(); 
	$output ="<ul  class=\"subjects\">";
	while ($subject=$subject_set->fetch_assoc()) {
	    $output.="<li";
	    if ($subject["id"]==$p_subject["id"]) {
		    $output.= " class=\"selected\"" ;
	    }
		$output.=">";
		$output.="<a href=\"manage_content.php?subject=";
		$output.=urlencode($subject["id"])."\">{$subject["menu_name"]}</a>";
		$output.="<ul class=\"pages\">";
		$page_set = find_pages_for_subject($subject["id"]); 
		while ($pages=$page_set->fetch_assoc()) {
			$output.="<li"; 
			if ($pages["id"]==$p_page["id"]) {
			   $output.=" class=\"selected\"";
			}
			$output.=">"; 
			$output.="<a href=\"manage_content.php?page=";
			$output.=urlencode($pages["id"]);
			$output.="\">";
			$output.=$pages["menu_name"];
			$output.="</a></li>";
		}
        $page_set->free_result();
		$output.="</ul></li>";
	}
	$output.="</ul>";
	$subject_set->free_result();
	
	return $output;
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>{$error}</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}
?>
