<?php
	$table_data = new DatabaseTableStructure($table, $database->connection);	
	$table_data->generate();

?>
<h4>
	<span style="color:rgb(216,216,216)">
	Insert to 
	</span>
	<?php
	if(!Data::is_table_data($table, "title"))
		echo ucwords(str_replace("_", " ", $table));
	else
		echo Data::get_table_data($table, "title");
	?>
</h4>

<form method="post">
<div class="adminForm row">

<?php foreach ($table_data->structure as $column => $column_meta): 
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
?>
	
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Label:
		</div>
		<div class="col s8">
			<input name="inputname" type="text" value="Default" />
		</div>
	</div>

<?php endforeach; ?>

	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input name="page_submit" class="btn color-purple waves-effect waves-light" type="submit" value="Insert" />
		</div>
	</div>
</div>
</form>