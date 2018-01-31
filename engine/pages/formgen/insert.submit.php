<?php

if(isset($_POST["page_submit"])){
	$column_build = "";
	$value_build = "";
	foreach ($structure as $column_meta){ 
		$column = $column_meta["Field"];
		if(Data::has_column($table, $column)){
			//$column_data = array_merge(Data::get_column($table, $column), Data::get_table_data($table, "default_column"));
			$column_data = Data::get_table_data($table, "default_column");
			foreach (Data::get_column($table, $column) as $prop => $prop_value) {
				$column_data[$prop] = $prop_value;
			}
		}else
			$column_data = Data::get_table_data($table, "default_column");
		if(isset($_POST["column_".$column]))
			$column_value = $_POST["column_".$column];
		else{
			if(isset($column_data["default"]))
				$column_value = $column_data["default"];
			else
				$column_value = "UNDEFINED";
		}
			
		$real_column_value = $column_value;

		if(Data::has_column_prop($table, $column, "alpha")){
			$alpha = Data::get_column_prop($table, $column, "alpha");
			$column_value = call_user_func($alpha);
		}
		if(Data::has_column_prop($table, $column, "beta")){
			$beta = Data::get_column_prop($table, $column, "beta");
			$column_value = call_user_func_array($beta, [$real_column_value]);
		}

		$column_stringify = false;
		if(isset($column_data["stringify"]) and $column_data["stringify"] == false)
			$value_build .= $column_value . ",";
		else
			$value_build .= "'" . $database->connection->real_escape_string($column_value) . "',";
		$column_build .= $column . ",";
	}
	$column_build = "(" . rtrim($column_build, ",") . ")";
	$value_build = "(" . rtrim($value_build, ",") . ")";
	$query = "INSERT INTO " . $table . " " . $column_build . " VALUES " . $value_build . ";";
	$database->connection->query($query);
	//echo "<script>document.location='" . url("admin/data-view/".$table) . "'</script>";
}