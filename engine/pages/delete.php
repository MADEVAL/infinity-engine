<?php

if(count($url) > 0){
	$db = db();
	$page_id = $db->real_escape_string(array_shift($url));
	$query = $db->query("DELETE FROM routes WHERE id='$page_id'");
	$db->close();
	echo "<script>window.location='" . url("admin/pages") ."'</script>";
	require "engine/pages/pages.php";
}else{
	require "error.php";
}
?>