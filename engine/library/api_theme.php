<?php

define("ThemeOptText", 0);
define("ThemeOptNumber", 1);
define("ThemeOptDate", 2);
define("ThemeOptEmail", 3);
define("ThemeOptPages", 10);

class Script{
	function Pause(){
		throw new Exception("Script::Pause Function Deprecated");
		die();
		if($_SESSION["theme_editor"] == 1){
			echo ThemeAPI::refractPageDefaults(ob_get_clean(), array_pop(ThemeAPI::getURLComponents()));
		}else if($_SESSION["theme_editor"] == 2){
			//echo ThemeAPI::refractPageSettings_(ob_get_clean(), array_pop(ThemeAPI::getURLComponents()));
		}
		ob_end_clean();
	}
	function Resume(){
		throw new Exception("Script::Resume Function Deprecated");
		die();
		ob_start();
		// $data = ob_get_contents();
		// ob_clean();
		// echo $_SESSION["ob_pause_data"];
		// echo $data;
		// unset($_SESSION["ob_pause_data"]);
	}
}

class Theme_Page{
	function __construct($page_title, $page_file, $page_icon, $page_render, $theme_settings) {
		$this->title = $page_title;
		$this->file = $page_file;
		$this->icon = $page_icon;
		$this->render = $page_render;
		$this->settings = $theme_settings;
	}
}

class Theme_Settings{
	function __construct($setting_key, $default_value = "", $type = 0) {
		$this->key = $setting_key;
		$this->default = $default_value;
		$this->type = $type;
	}
}

class Theme_File{
	function __construct($file_name) {
		$this->file_name = $file_name;
	}
}

class Theme_Menu{
	function __construct($menu) {
		$this->menu = $menu;
	}
}

class Theme_Folder{
	function __construct($folder_name) {
		$this->folder_name = $folder_name;
	}
}

class Theme_Divider{
}

class Theme extends ThemeGet{
	function Page($page_title, $page_file, $page_icon = "note_add", $page_render = true, $theme_settings = []){
		return new Theme_Page($page_title, $page_file, $page_icon, $page_render, $theme_settings);
	}
	function Settings($key, $default="", $type = 0){
		return new Theme_Settings($key, $default, $type);
	}
	function Options($key, $default="", $type = 0){
		return new Theme_Settings($key, $default, $type);
	}
	function File($file_name){
		return new Theme_File($file_name);
	}
	function Folder($folder_name){
		return new Theme_Folder($folder_name);
	}
	function Divider(){
		return new Theme_Divider();
	}
	function Menu($name){
		return new Theme_Menu($name);
	}
	function ErrorTitle(){
		if(isset($_SESSION["theme_error_title"])){
			echo $_SESSION["theme_error_title"];
		}else{
			echo "Unidenitified Error.";
		}
	}
	function ErrorMessage(){
		if(isset($_SESSION["theme_error_message"])){
			echo $_SESSION["theme_error_message"];
		}else{
			echo "Error data has not been logged.";
		}
	}
	function Title(){
		echo SiteSettings::get("SITE_TITLE_PREFIX");
		if(ThemeAPI::is_editable() == 1){
			echo "Theme Editor";
		}elseif(ThemeAPI::is_editable() == 2){
			//Pass Out for theme building.
		}elseif(isset($_SESSION["theme_data"])){
			echo $_SESSION["theme_data"]["title"];
		}
		echo SiteSettings::get("SITE_TITLE_SUFFIX");

	}
	function Information($setting){
		return SiteSettings::get($setting);
	}
	function Content(){
		if(ThemeAPI::is_editable() == 1){
			$working_theme = SiteSettings::get("WORKING_THEME");
			$page = array_pop(ThemeAPI::getURLComponents());
			require "content/themes/" . $working_theme . "/pages/" . $page . ".php";
		}else
		if(ThemeAPI::is_editable() == 2){
			$working_theme = SiteSettings::get("WORKING_THEME");
			$page = array_pop(ThemeAPI::getURLComponents());
			require "content/themes/" . $working_theme . "/pages/" . $page . ".php";
		}else{
			require "content/pages/" . $_SESSION["theme_data"]["file"];
		}
	}
	function URL($url="", $template = true){
		if($template){
			$working_theme = SiteSettings::get("WORKING_THEME");
			return url("content/themes/" . $working_theme . "/" . $url);
		}else{
			return url($url);
		}
	}
	function User($node="name"){
		return $_SESSION["user"][$node];
	}
	function BaseURL($url=""){
		return url($url);
	}
	function Header(){
		if(ThemeAPI::is_editable() == 1){
			echo "<link rel='stylesheet' href='" . url("assets/ContentTools/content-tools.min.css") . "'/>\n";
			echo "<script src='" . url("assets/ContentTools/content-tools.min.js") . "'></script>\n";
			echo "<link rel='stylesheet' href='" . url("assets/ContentTools/content-tools-admin.css") . "'/>\n";
			echo "<script src='" . url("assets/ContentTools/content-tools-admin.js") . "'></script>\n";
			echo "<script>window.baseURL = '" . url() . "'</script>\n";
			echo "<script>window.templatePage = '" . array_pop(ThemeAPI::getURLComponents()) . "'</script>\n";
			ThemeGet::DynamicHeader(array_pop(ThemeAPI::getURLComponents()));
		}
	}
	function Editable($title = "main-content"){
		if(ThemeAPI::is_editable() == 1){
			echo ' data-editable data-name="' . $title . '" ';
		}
	}
	function Uneditable(){
		if(ThemeAPI::is_editable() == 1){
			echo ' contenteditable="false" ';
		}
	}
	function Element($title = "main-content"){
		if(ThemeAPI::is_editable() == 1){
			ob_start();
		}
		if(ThemeAPI::is_editable() == 2){
			if(isset($_POST[$title])){echo $_POST[$title];}
			ob_start();
		}
	}
	function Package($title = "main-content"){
		if(ThemeAPI::is_editable() == 1){
			$data = ob_get_contents();
			ob_end_clean();
			echo $data;
		}
		if(ThemeAPI::is_editable() == 2){
			$data = ob_get_contents();
			ob_end_clean();
			if(isset($_POST[$title])){}else echo $data;
		}
	}
	function xURL(){
		if(isset($_SESSION["extended_url"])){
			return $_SESSION["extended_url"];
		}else return 0;
	}
	function isViewing(){
		if(isset($_SESSION["theme_editor"]) and $_SESSION["theme_editor"] != 0)
			return false;
		else
			return true;
	}
}
class ThemeAPI{
	function refractPageDefaults($data, $page){
		$settings = ThemeAPI::settings();
		foreach ($settings["pages"] as $page_) {
			if($page_->file == $page){
				$opts = $page_->settings;
				foreach ($opts as $opt) {
					$data = str_replace("<%" . $opt->key . "%>", $opt->default, $data);
				}
				return $data;
			}
		}
	}
	function refractPageSettings($data, $page_id, $settings){
		$db = db();
		$page = $db->query("SELECT * FROM routes WHERE id = '$page_id'")->fetch_assoc()["page"];
		$opts = [];
		
		$query = $db->query("SELECT * FROM settings_page WHERE route='$page_id'");
		
		foreach ($settings as $setting) {
			$opts[$setting->key] = $setting->default;
		}
			while($row = $query->fetch_array()){
				foreach ($opts as $key => $value) {
					if($key == $row["node"]){
						$opts[$key] = $row["value"];
					}
				}
			}
			foreach ($opts as $key => $value) {
				$data = str_replace("<%" . $key . "%>", $value, $data);
			}
		$db->close();
		return $data;
	}
	function refractPageSettings_($data, $page_id){
		$db = db();
		$page = $db->query("SELECT * FROM routes WHERE id = '$page_id'")->fetch_assoc()["page"];
		$opts = [];
		$theme_settings = ThemeAPI::settings();
		$page_settings = $theme_settings["pages"];
		 
		$query = $db->query("SELECT * FROM settings_page WHERE route='$page_id'");
		
		foreach ($settings as $setting) {
			$opts[$setting->key] = $setting->default;
		}
			while($row = $query->fetch_array()){
				foreach ($opts as $key => $value) {
					if($key == $row["node"]){
						$opts[$key] = $row["value"];
					}
				}
			}
			foreach ($opts as $key => $value) {
				$data = str_replace("<%" . $key . "%>", $value, $data);
			}
		$db->close();
		return $data;
	}
	function getUrl(){
		$url = explode_url($_SERVER["REQUEST_URI"]);
		array_shift($url);
		$linkage = implode("/", $url);
		$url = ($linkage == "")?"/":"/".$linkage;
		return $url;
	}
	function getUrlComponents(){
		$url = explode_url($_SERVER["REQUEST_URI"]);
		array_shift($url);
		return $url;
	}
	function buildPage(){
		$url = ThemeAPI::getUrl();
		$working_theme = SiteSettings::get("WORKING_THEME");
		$_SESSION["theme_route"] = $url;
		$db = db();
		$query = $db->query("SELECT * FROM routes WHERE route = '" . $db->real_escape_string($url) . "' AND template = '" . $working_theme . "'");
		if($query->num_rows == 1){
			$theme_data = $query->fetch_assoc();
			if($theme_data["is_public"] == 1){
				$_SESSION["theme_data"] = $theme_data;
				$theme = SiteSettings::get("WORKING_THEME");
				$theme_settings = ThemeAPI::settings();
				$theme_index = $theme_settings["index"]->file_name;
				foreach ($theme_settings["pages"] as $page) {
					if($page->file == $theme_data["page"]){
						$reqd_page = $page;
					}
				}
				if(isset($reqd_page)){
					$settings = $reqd_page->settings;
				}else{
					$settings = [];
				}
				ob_start();
				require "content/themes/" . $theme . "/" . $theme_index;
				$data = ob_get_contents();
				ob_end_clean();
				echo ThemeAPI::refractPageSettings($data, $theme_data["id"], $settings);
			}else{
				$_SESSION["theme_error_title"] = "Page is Hidden";
				$_SESSION["theme_error_message"] = "Sorry the page is not available for viewing.";
				$working_theme = SiteSettings::get("WORKING_THEME");
				$theme_file = "content/themes/" . $working_theme . "/error.php";
				require $theme_file;
				exit();
			}
		}else{
			$urlComps = explode("/" , ltrim($url, "/"));
			$url = "/" . array_shift($urlComps);
			$query = $db->query("SELECT * FROM routes WHERE route = '" . $db->real_escape_string($url) . "' AND template = '" . $working_theme . "'");
			if($query->num_rows == 1){
				$theme_data = $query->fetch_assoc();
				if($theme_data["is_public"] == 1){
					$_SESSION["theme_data"] = $theme_data;
					$theme = SiteSettings::get("WORKING_THEME");
					$theme_settings = ThemeAPI::settings();
					$theme_index = $theme_settings["index"]->file_name;
					$_SESSION["extended_url"] = implode("/", $urlComps);
					require "content/themes/" . $theme . "/" . $theme_index;
				}else{
					$_SESSION["theme_error_title"] = "Page is Hidden";
					$_SESSION["theme_error_message"] = "Sorry the page is not available for viewing.";
					$working_theme = SiteSettings::get("WORKING_THEME");
					$theme_file = "content/themes/" . $working_theme . "/error.php";
					require $theme_file;
					exit();
				}
			}else{
				$_SESSION["theme_error_title"] = "Page Not Found";
				$_SESSION["theme_error_message"] = "The page you are looking for does not exist or has been deleted.";
				$working_theme = SiteSettings::get("WORKING_THEME");
				$theme_file = "content/themes/" . $working_theme . "/error.php";
				require $theme_file;
				exit();
			}
		}
		$db->close();
		die();
	}
	function editMode($enable = 1){
		$_SESSION["theme_editor"] = $enable;
	}
	function buildMode($enable = 2){
		$_SESSION["theme_editor"] = $enable;
	}
	function is_editable(){
		if(isset($_SESSION["theme_editor"]))
			return $_SESSION["theme_editor"];
		else
			return 0;
	}
	function settings($custom_theme = ""){
		if($custom_theme == ""){
			$working_theme = SiteSettings::get("WORKING_THEME");
		}else{
			$working_theme = $custom_theme;
		}
		$theme_file = "content/themes/" . $working_theme . "/theme.php";
		if(!is_dir("content/themes/" . $working_theme)){
			throw new Exception( "Activated theme '" . $working_theme . "' does not exist.", 1000);
		}
		if(file_exists($theme_file)){
			require $theme_file;
		}else{
			throw new Exception( $working_theme . " has no theme options.", 1000);
		}
		if(isset($theme)){
			if(isset($theme["index"])){
				return $theme;
			}else{
				throw new Exception( $working_theme . " has invalid theme config. Index File Not Provided.", 1000);
			}
		}else{
			throw new Exception( $working_theme . " has no theme options in the file.", 1000);
		}
	}
}