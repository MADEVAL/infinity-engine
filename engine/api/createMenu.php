<?php

if(isset($_SESSION["user"]["id"])){
	if(isset($_POST["createMenu"])){
		if(isset($_POST["menuData"])){
			$menu_title = $_POST["createMenu"];
			$menu_data = $_POST["menuData"];
			$working_theme = SiteSettings::get("WORKING_THEME");
			$db = db();
			$query = $db->query("SELECT * FROM menus WHERE menu_title='" . $menu_title . "'");
			if($query->num_rows == 1){
				//Update
				$row = $query->fetch_assoc();
				$qstring = "UPDATE menus SET menu_data = '" . $menu_data . "' WHERE menu_id = '" . $row["menu_id"] . "'";
				$db->query($qstring);
				$success[] = "Menu was updated.";
			}else{
				//Insert
				$db->query("INSERT INTO menus VALUES(NULL, '" . $menu_title . "', '" . $menu_data . "' ,'" . $working_theme . "')");
				$success[] = "Menu was created.";
			}
			$db->close();
		}else{
			$errors[] = "No data was provided";
		}
	}
}