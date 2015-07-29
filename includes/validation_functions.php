<?php
$errors = array();

function fieldname_as_text($fn) {
	$fn= str_replace("_"," ",$fn);
	$fn= ucfirst($fn);
	return $fn;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
	if ($value) {
		return isset($value) && $value !== "";
	}
	else {
		return False;
	}
}

function validate_has_presences($fields_with_presence) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_presence as $field ) {
		$value=isset($_POST[$field]) ? trim($_POST[$field]) : null;
		if (!has_presence($value)) {
			$errors[$field] = fieldname_as_text($field) . " cannot be blank";
		}
	}
}

// * string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if (!has_max_length($value, $max)) {
			$errors[$field] = fieldname_as_text($field) . " is too long";
		}
	}
}
// * inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}


?>