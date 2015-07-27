<?php
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

function confirm_query($result) {
	if (!$result) {
		die("database query failed");
	}
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

function navigation($selected_subject_id, $selected_page_id) {

	$subject_set = find_all_subjects(); 
	$output ="<ul  class=\"subjects\">";
	while ($subject=$subject_set->fetch_assoc()) {
	    $output.="<li";
	    if ($subject["id"]==$selected_subject_id) {
		    $output.= " class=\"selected\"" ;
	    }
		$output.=">";
		$output.="<a href=\"manage_content.php?subject=";
		$output.=urlencode($subject["id"])."\">{$subject["menu_name"]}</a>";
		$page_set = find_pages_for_subject($subject["id"]); 
		$output.="<ul class=\"pages\">";
		while ($pages=$page_set->fetch_assoc()) {
			$output.="<li"; 
			if ($pages["id"]==$selected_page_id) {
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

