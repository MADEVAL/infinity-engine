<?php

	class SiteSettings{
		function get($node){
			$connection = db();	
			$query = $connection->query("SELECT value FROM settings_site WHERE node = '$node'");
			if($query->num_rows == 1){
				$value = $query->fetch_assoc()["value"];
			}else{
				$value = -1;
			}
			$connection->close();
			return $value;
		}
		function set($node, $value){
			$connection = db();	
			$query = $connection->query("UPDATE settings_site SET value='$value' WHERE node='$node'");
			$value = $connection->affected_rows;
			$connection->close();
			return $value;
		}
	}

	class ThemeSettings{
		function get($node){
			$connection = db();
			$theme = SiteSettings::get("WORKING_THEME");
			$query = $connection->query("SELECT value FROM settings_theme WHERE node = '$node' AND theme='$theme'");

			if($query->num_rows == 1){
				$value = $query->fetch_assoc()["value"];
			}else{
				$value = -1;
			}
			$connection->close();
			return $value;
		}
		function set($node, $value, $err){
			$connection = db();
			$theme = SiteSettings::get("WORKING_THEME");
			$query = $connection->query("SELECT value FROM settings_theme WHERE node = '$node' AND theme='$theme'");
			if($query->num_rows == 0){
				$query = $connection->query("INSERT INTO settings_theme VALUES(NULL, '$node', '$value', '$theme')");
			}else{
				$query = $connection->query("UPDATE settings_theme SET value='$value' WHERE node='$node' AND theme='$theme'");
			}
			$value = $connection->affected_rows;

			$connection->close();
			return $value;
		}
	}

	class PageSettings{
		function get($node, $route){
			$connection = db();

			$query = $connection->query("SELECT value FROM settings_page WHERE node = '$node' AND route='$route'");

			if($query->num_rows == 1){
				$value = $query->fetch_assoc()["value"];
			}else{
				$value = -1;
			}
			$connection->close();
			return $value;
		}
		function set($node, $value, $route){
			$connection = db();
			$query = $connection->query("SELECT value FROM settings_page WHERE node = '$node' AND route='$route'");
			if($query->num_rows == 0){
				$query = $connection->query("INSERT INTO settings_page VALUES(NULL, '$node', '$value', '$route')");
			}else{
				$query = $connection->query("UPDATE settings_page SET value='$value' WHERE node='$node' AND route='$route'");
			}
			$value = $connection->affected_rows;

			$connection->close();
			return $value;
		}
	}
	class Notifier{
		function notify($title, $message, $icon, $user){
			$time = time();
			$connection = db();
			$query = $connection->query("INSERT INTO notifications VALUES(NULL, '$title', '$message', '$icon', '$user', '$time')");
			$value = $connection->affected_rows;
			$connection->close();
			return $value;
		}
	}