<?php

if(isset($_POST["downloadTable"])){
	$table = $_POST["downloadTable"];
	$db = db();
	$query = $db->query("SELECT * FROM $table");

	$csv = "";
	while($row = $query->fetch_assoc()){
		foreach ($row as $key => $value) {
			$csv .= $value . ",";
		}
		$csv = rtrim($csv, ",");
		$csv .= "\n";
	}
	//print($csv);
	//$data[] = $csv;
	$db->close();
}