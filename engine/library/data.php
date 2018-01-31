<?php

define("DATA_VIEW", 100);
define("DATA_EDIT", 101);
define("DATA_INSERT", 102);
define("DATA_REMOVE", 103);
define("DATA_DOWNLOAD", 104);

$theme = SiteSettings::get("WORKING_THEME");

require "content/themes/" . $theme . "/data.php";

if(isset($data))
	$_SESSION["engine_data"] = $data;
else
	$_SESSION["engine_data"] = [];

class Data{
	function is_table($table){
		foreach ($_SESSION["engine_data"] as $tablename => $tabledata) {
			if($table == $tablename){
				return true;
			}
		}
		return false;
	}
	function get_table($table){
		return $_SESSION["engine_data"][$table];
	}
	function get_table_data($table, $info){
		return $_SESSION["engine_data"][$table][$info];
	}
	function is_table_data($table, $info){
		return isset($_SESSION["engine_data"][$table][$info]);
	}
	function has_column($table, $column){
		return isset(Data::get_table_data($table, "columns")[$column]);
	}
	function get_column($table, $column){
		return Data::get_table_data($table, "columns")[$column];
	}
	function has_column_prop($table, $column, $prop){
		return isset(Data::get_table_data($table, "columns")[$column][$prop]);
	}
	function get_column_prop($table, $column, $prop){
		return Data::get_table_data($table, "columns")[$column][$prop];
	}
	function is_table_permission($table, $perm){
		if(Data::is_table($table)){
			$tabledata = Data::get_table($table);
			if(isset($tabledata["permissions"])){
				foreach($tabledata["permissions"] as $permission){
					if($perm == $permission){
						return true;
					}
				}
				return false;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}