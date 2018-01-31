<?php

class ThemeGet{
	function getSettings($option){
		$theme_name = SiteSettings::get("WORKING_THEME");
		$db = db();
		$query = $db->query("SELECT value FROM settings_theme WHERE node='$option' AND theme='$theme_name'");
		if($query->num_rows==1){
			$row = $query->fetch_assoc();
			$value = $row["value"];
		}else{
			$theme = ThemeApi::settings();
			$value = $theme["settings"][$option]->default;
		}
		$db->close();
		return $value;
	}
	function getPageSettings($option){
		$url = ThemeApi::getUrl();
		$db = db();
		$query = $db->query("SELECT id,page FROM routes WHERE route='$url'");
		$value = null;
		if($query->num_rows == 1){
			$data = $query->fetch_assoc();
			$route = $data["id"];
			$page = $data["page"];
			$query = $db->query("SELECT value FROM settings_page WHERE route='$route' AND node='$option'");
			if($query->num_rows == 1){
				$value = $query->fetch_assoc()["value"];
			}else{
				$theme_pages = ThemeApi::settings()["pages"];
				$req_page = null;
				foreach ($theme_pages as $theme_page) {
					if($theme_page->file == $page){
						$req_page = $theme_page;
					}
				}
				if($req_page == null){
					throw new Exception("Requested page does not exist in theme settings.", 1);
				}else{
					$req_setting = null;
					foreach($theme_page->settings as $setting){
						if($setting->key == $option){
							$req_setting = $setting;
						}
					}
					if($req_setting == null){
						throw new Exception("Requested Setting does not exist in page options.", 1);
					}else{
						$value = $req_setting->default;
					}
				}
			}
		}else{
			throw new Exception("Requested route wasn't found using ThemeApi::getUrl");
		}
		$db->close();
		return $value;
	}
	function getCustomPageSettings($option, $url){
		$db = db();
		$query = $db->query("SELECT id,page FROM routes WHERE route='$url'");
		$value = null;
		if($query->num_rows == 1){
			$data = $query->fetch_assoc();
			$route = $data["id"];
			$page = $data["page"];
			$query = $db->query("SELECT value FROM settings_page WHERE route='$route' AND node='$option'");
			if($query->num_rows == 1){
				$value = $query->fetch_assoc()["value"];
			}else{
				$theme_pages = ThemeApi::settings()["pages"];
				$req_page = null;
				foreach ($theme_pages as $theme_page) {
					if($theme_page->file == $page){
						$req_page = $theme_page;
					}
				}
				if($req_page == null){
					throw new Exception("Requested page does not exist in theme settings.", 1);
				}else{
					$req_setting = null;
					foreach($theme_page->settings as $setting){
						if($setting->key == $option){
							$req_setting = $setting;
						}
					}
					if($req_setting == null){
						throw new Exception("Requested Setting does not exist in page options.", 1);
					}else{
						$value = $req_setting->default;
					}
				}
			}
		}else{
			throw new Exception("Requested route wasn't found using ThemeApi::getUrl");
		}
		$db->close();
		return $value;
	}
	function getGlobalSettings($option){
		$value = SiteSettings::get($option);
		return $value;
	}
	function SiteTitle(){
		$value = SiteSettings::get("SITE_TITLE");
		return $value;
	}
	function getMenu($menu){
		$theme_name = SiteSettings::get("WORKING_THEME");
		$db = db();
		$query = $db->query("SELECT * FROM menus WHERE menu_title='$menu' AND menu_theme='$theme_name';");

		$menu = [];
		if($query->num_rows == 1){
			$menu = $query->fetch_assoc();
		}else{
			$menu["menu_data"] = "[]";
		}
		$db->close();
		return json_decode($menu["menu_data"], true);
	}
	function DynamicHeader($page){
		$theme = ThemeAPI::settings();
		$found = false;
		foreach ($theme["pages"] as $_page) {
			if(strtolower($_page->file) == strtolower($page)){
				$found = true;
				if($_page->render == false){
					echo "<script src='" . url("assets/ContentTools/content-tools-admin-unrendered.js") . "'></script>\n";
				}
			}
		}
	}
}
