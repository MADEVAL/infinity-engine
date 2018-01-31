<?php
	$table_data = new DatabaseTableStructure($table, $database->connection);	
	$table_data->generate();
	$structure = $table_data->structure;
	$column_key = array_shift($url);
	$column_value = array_shift($url);
	$global_column_key = $column_key;
	$global_column_value = $column_value;
	if($column_key == "" or $column_value == ""){
		$errorTitle = "Unknown Data Entered";
		$errorMessage = "";
		require "engine/pages/error.php";
		die();
	}
	$default_row = $database->connection->query("SELECT * FROM $table WHERE $column_key = '$column_value'")->fetch_assoc();

?>
<h4 style="text-align:center">
	<span style="color:rgb(216,216,216)">
	Editing  
	</span>
	<?php
	if(!Data::is_table_data($table, "title"))
		echo ucwords(str_replace("_", " ", $table));
	else
		echo Data::get_table_data($table, "title");
	?>
</h4>
<?php
	require "update.submit.php";
?>
<form method="post">
<div class="adminForm row">

<?php 
foreach ($structure as $column_meta): 
$column = $column_meta["Field"];

if(Data::has_column($table, $column)){

	$column_conf = Data::get_column($table, $column);

}else{
	if(Data::is_table_data($table, "default_column")){

		$column_conf = Data::get_table_data($table, "default_column");

	}else{

		$errorTitle="Default Column Data Unknown";
		$errorMessage="Please add default column data to the data configuration file.";
		require "engine/pages/divider.php";
		require "engine/pages/error.php";

	}
}

if(Data::has_column_prop($table, $column, "type")){
	$column_type = Data::get_column_prop($table, $column, "type");
}else{
	$column_type = Data::get_table_data($table, "default_column")["type"];
}

if(Data::has_column_prop($table, $column, "default")){
	$column_default = Data::get_column_prop($table, $column, "default");
}else{
	$column_default = Data::get_table_data($table, "default_column")["default"];
}

$lambda = false;
$placeholder = false;
if(Data::has_column_prop($table, $column, "alpha")){
	$column_default = call_user_func(Data::get_column_prop($table, $column, "alpha"));
	$lambda = true;
}
if(Data::has_column_prop($table, $column, "beta")){
	$column_default = call_user_func_array(Data::get_column_prop($table, $column, "beta"), [""]);
	$lambda = false;
	$placeholder = true;
}

if($lambda){
	continue;
}
if($column_type == "text"):
?>
	<div class="inputGroup">
		<div class="col s3 formLabel">
			<?=ucwords(str_replace("_", " ", $column))?>:
		</div>
		<div class="col s8">
			<input <?php if($lambda) echo "disabled";?> name="column_<?=$column?>" type="text" <?php echo "value";?>="<?=$default_row[$column]?>" />
		</div>
	</div>
<?php
elseif($column_type == "none"):

endif;
?>


<?php
endforeach; 
?>

	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input name="page_submit" class="btn color-purple waves-effect waves-light" type="submit" value="Update" />
		</div>
	</div>
</div>
</form>