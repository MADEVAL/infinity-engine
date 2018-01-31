<?php

if(count($url) > 0){
	$root = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/";
	$file = array_shift($url);
	unlink($root.$file);
	echo "<script>window.location='" . url("admin/files") ."'</script>";
}else{
	require "error.php";
}
?>