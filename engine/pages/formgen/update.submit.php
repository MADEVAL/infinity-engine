<?php

if(isset($_POST["page_submit"])){
	$column_build = "";
	$value_build = "";
	$main_build = "";
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
			if(isset($column_data["default"])){
				$column_value = $column_data["default"];
				continue;
			}else{
				$column_value = "UNDEFINED";
			}
		}
			
		$real_column_value = $column_value;

		$lambda = false;
		if(Data::has_column_prop($table, $column, "alpha")){
			$alpha = Data::get_column_prop($table, $column, "alpha");
			$column_value = call_user_func($alpha);
			$lambda = true;
		}
		if(Data::has_column_prop($table, $column, "beta")){
			$beta = Data::get_column_prop($table, $column, "beta");
			$column_value = call_user_func_array($beta, [$real_column_value]);
			$lambda = false;
		}
		if($lambda == true){continue;}

		$column_stringify = false;
		$cur_value = "";
		$cur_col = "";
		if(isset($column_data["stringify"]) and $column_data["stringify"] == false)
			$cur_value = $column_value;
		else
			$cur_value = "'" . $database->connection->real_escape_string($column_value) . "'";
		$cur_col = $column;
		$main_value = $cur_col . " = " . $cur_value . ",";
		$main_build .= $main_value;
	}
	$main_build = rtrim($main_build, ",");
	$query = "UPDATE " . $table . " SET " . $main_build . " WHERE " . $global_column_key . " = '" . $global_column_value . "';";
	$database->connection->query($query);
	echo "<script>window.location = window.location.href;</script>";
}