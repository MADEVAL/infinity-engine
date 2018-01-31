<?php

session_start();

define("ENTRY_POINT_ADMIN", "admin");
define("EXIT_POINT_ERROR", "error");
define("EXIT_POINT_LOGIN", "login");
define("EXIT_POINT_SIGNUP", "signup");
define("EXIT_POINT_RECOVER", "recover");

function explode_url($url){
	$array = [];
	foreach (array_filter(explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL))) as $element) { $array[] = $element; }
	return $array;
}

function url($something = ""){
	return BASE_URL . $something;
}
function redir($url){
	header("Location:".url($url));
}
function db(){
	return new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
}
function stmt_bind_assoc (&$stmt, &$out) {
	$data = mysqli_stmt_result_metadata($stmt);
	$fields = array();
	$out = array();

	$fields[0] = $stmt;
	$count = 1;

	while($field = mysqli_fetch_field($data)) {
		$fields[$count] = &$out[$field->name];
		$count++;
	}
	call_user_func_array("mysqli_stmt_bind_result", $fields);
}

function user_folder($user){
	return substr(md5($user), 0, 10);
}
function to_date($date){
	return DateTime::createFromFormat("Y-m-d", $date)->format(DATE_FORMAT);
}
function image_resize($file_url, $x, $y, $to_image){
	$file_components = explode("/", $file_url);
	array_pop($file_components);
	$folder = implode("/", $file_components);
	$resizeObj = new resize($file_url); 
	$resizeObj->resizeImage($x, $y, 'crop');
	$resizeObj->saveImage($folder . '/' . $to_image . '.jpg', 100);
}