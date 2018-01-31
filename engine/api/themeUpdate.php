<?php

if(isset($_POST["themeUpdate"])){
	$theme = $_POST["themeUpdate"];
	if(file_exists("content/themes/" . $theme . "/theme.php")){
		SiteSettings::set("WORKING_THEME", $theme);
		$success[] = "Theme Updated";
	}else{
		$errors[] = "Theme does not have theme file.";
	}
}