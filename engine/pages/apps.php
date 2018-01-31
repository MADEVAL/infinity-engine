<?php echo '<script type="text/javascript">document.title = "Apps - Infinity Engine"</script>'; ?>
<?php

$app_page = array_shift($url);

$app_url = implode("/", $url);

if($app_url == null){
	$app_url = "index.php";
}

if($app_page != null){
	if(is_dir("engine/apps/" . $app_page)){
		require "engine/apps/" . $app_page . "/" . $app_url;
	}else{
		$errorTitle = "App not found";
		$errorMessage = "The app you requested was not found in the apps directory.";
		require "error.php";
	}
}else{
	require "apps-welcome.php";
}

?>