<?php
	define("INFINITY_ENGINE", "3.0.0");
	require "engine/system/init.php";

	$url_comps = explode("?", $_SERVER["REQUEST_URI"]);

	if(count($url_comps) > 1){
		$get_string = array_pop($url_comps);
	}else{
		$get_string = "";
	}
	
	$get_array = explode("&", $get_string);

	foreach($get_array as $equation){
		$equation_array = explode("=", $equation);
		$_GET[array_shift($equation_array)] = array_shift($equation_array);
	}

	$traced_url = implode("?", $url_comps);

	$url = explode_url($traced_url);

	array_shift($url);

	$route_location = strtolower(array_shift($url));

	if($route_location == ENTRY_POINT_ADMIN){
		require "engine/admin.php";
	}else{
		ThemeAPI::buildPage();
	}