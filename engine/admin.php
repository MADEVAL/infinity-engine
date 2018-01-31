<?php

	if(count($url) == 0){ 
		if(!isset($_SESSION["user"])) {
			$page = "login";
		}else{
			$page = "welcome";
		}
	} else { 
		$page = array_shift($url);

		if($page == "api"){
			require "api.php";
			exit();
		}

		if($page == "page"){
			require "theme-editor.php";
			exit();
		}

		if(!isset($_SESSION["user"])) {
			if (!in_array($page, array(EXIT_POINT_LOGIN, EXIT_POINT_SIGNUP, EXIT_POINT_RECOVER))) {
				$page = EXIT_POINT_ERROR;
			}
		}
	}

	$file = "engine/pages/" . $page . ".php";
	$userfile = "engine/pages/login/" . $page . ".php";
	$error_file = "engine/pages/" . EXIT_POINT_ERROR . ".php";

	if(!isset($_SESSION["user"])){
		$file = $userfile;
		require "template-user.php";
	}else{
		require "template-admin.php";
	}
