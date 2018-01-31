<?php

require "engine/library/db_orm.php";

$table = array_shift($url);
$database = new DatabaseStructure();
$database->generate();
$structure = $database->structure;

if(Data::is_table($table) and in_array($table, $structure)):
	require "formgen/insert.php";
else:
	$errorTitle = "Data Table not available";
	$errorMessage = "The requested Data Table doesn't exist or it is not configured in data configuration file.";
	require "error.php";
endif;

$database->release();