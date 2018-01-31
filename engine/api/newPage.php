<?php
	if(isset($_POST["_newPage"])){
		$db = db();
		
		$working_theme = SiteSettings::get("WORKING_THEME");
		$page = $_POST["_PageName"];
		

		require "content/themes/".$working_theme."/theme.php";


		$render = true;
		foreach ($theme["pages"] as $_page) {
			if($_page->file == $page){
				if($_page->render == false){
					$render = false;
				}
			}
		};
		$working_page = "content/themes/".$working_theme."/pages/" . $page . ".php";
		$working_page2 = $page;

		if($render == true){
			ThemeAPI::buildMode();
			ob_start();
			require $working_page;
			$data = ob_get_contents();
			ob_end_clean();
		}else{
			$data = file_get_contents($working_page);
		}

		$dir = "content/pages/";
		$file_name = md5($_SESSION["user"]["id"] . time() . rand()) . ".html";
		file_put_contents($dir . $file_name, $data);
		
		$db->query("INSERT INTO routes VALUES(NULL, '', '" . $file_name . "', '/" . $file_name . "' ,'', '" . $working_page2 . "', '" . $working_theme . "' ,'" . $_SESSION["user"]["id"] ."' ,1 ,'" . date(DATE_FORMAT) . "')");
		$insert_id = $db->insert_id;
		$data = [];
		$success[] = $insert_id;
		$db->close();
		ThemeAPI::buildMode(0);
	}
