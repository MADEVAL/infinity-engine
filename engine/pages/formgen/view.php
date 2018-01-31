<?php
	$index = array_shift($url);
	if($index != "" and ctype_digit($index)){
		//Pass
	}else{
		$index = 0;
	}
	$limit = 25;
	
	$table_data = new DatabaseTableStructure($table, $database->connection);	
	$table_data->generate();
	$n_index = $index;
	$n_rows = intval($database->connection->query("SELECT COUNT(id) AS n_rows FROM $table")->fetch_assoc()["n_rows"]);

?>
<h4 style="text-align:center;">
	<?php
	if(!Data::is_table_data($table, "title"))
		echo ucwords(str_replace("_", " ", $table));
	else
		echo Data::get_table_data($table, "title");
	?>
</h4>
<style type="text/css">
.custom-highlight{

}
.custom-highlight td{
	text-align: center;
}
.custom-highlight tbody tr:hover{
	background: rgb(48,50,52);
	box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.1);
}
.smallbtn{
		font-size:10px;
		background:rgb(230,230,230);
		border-radius: 100px;
		padding:3px;
		padding-left:10px;
		padding-right:10px;
		display: block;
		margin-top: 2px;
		margin-left:0px !important;
		width: 100%;
		text-align: center;
		color:rgb(10,10,200) !important;
	}
</style>
<table class="custom-highlight">
	<thead>
		<tr>
		<?php
			$column_display = [];
			$column_primary_and_ai = "";
			foreach ($table_data->structure as $column_data):
				$column = $column_data["Field"];
				if($column_data['Key'] == "PRI" and $column_data['Extra']=='auto_increment'){
					$column_primary_and_ai = $column;
				}
				$column_data = Data::get_table_data($table, "default_column");
				if(Data::has_column($table, $column)){
					foreach (Data::get_column($table, $column) as $prop => $prop_value) {
						$column_data[$prop] = $prop_value;
					}
				}
				$column_display[$column] = "text";
				if(isset($column_data["display"])){
					$column_display[$column] = $column_data["display"];
				}
				if($column_display[$column]== "none") continue;
		?>
			<td><?=ucwords(str_replace("_", " ", $column))?></td>
		<?php endforeach; ?>
			<td>Options</td>

		</tr>
	</thead>
	<tbody>
		<?php
			$query = $database->connection->query("SELECT * FROM $table ORDER BY id DESC LIMIT $index, $limit");
			while($row = $query->fetch_assoc()):
		?>
		<tr>
			<?php foreach ($table_data->structure as $column_data): 
				$column = $column_data["Field"];
				if($column_display[$column]== "none") continue;
				$column_data = Data::get_table_data($table, "default_column");
				if(Data::has_column($table, $column)){
					foreach (Data::get_column($table, $column) as $prop => $prop_value) {
						$column_data[$prop] = $prop_value;
					}
				}
				if(isset($column_data["display"]) and $column_data["display"] != "none"){
			?>
				<td><?php
				switch ($column_data["display"]) {
					case 'text':
						echo substr($row[$column], 0,50);
						if(strlen($row[$column]) != strlen(substr($row[$column], 0,50))){ echo "..."; }
						break;
					case 'link':
						echo "<a class='blue-text' href='" . $row[$column]."' target='_blank'>Goto</a>" ;
						break;
					case 'image':
						echo "<img class='responsive-img' src='" . $row[$column]."' />" ;
						break;
					
					default:
						echo substr($row[$column], 0,50);
						if(strlen($row[$column]) != strlen(substr($row[$column], 0,50))){ echo "..."; }
						break;
				}
				?></td>
			<?php
				}
				else{
			?>
				<td><?php echo substr($row[$column], 0,50); if(strlen($row[$column]) != strlen(substr($row[$column], 0,50))){ echo "..."; }?></td>
			<?php } ?>
			<?php endforeach; ?>
			<td>
			<?php
				if($column_primary_and_ai != ""):
				$index = $row[$column_primary_and_ai];
			?>
			<a class="smallbtn" href="<?=url()?>admin/data-edit/<?=$table?>/<?=$column_primary_and_ai?>/<?=$row[$column_primary_and_ai]?>">Edit</a>
			<a class="smallbtn" href="<?=url()?>admin/data-delete/<?=$table?>/<?=$column_primary_and_ai?>/<?=$row[$column_primary_and_ai]?>">Delete</a>
			<?php endif; ?>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<?php
	if($column_primary_and_ai == ""):
?>
<script type="text/javascript">
	Materialize.toast("You need to have atleast 1 column with both PRIMARY and AUTO INCREMENT working.");
</script>
<?php endif; ?>

<?php
	$next_disabled = false;
	$prev_disabled = false;
	if($n_index + $limit <= $n_rows){
		$next_index = $n_index + $limit;
	}else{
		$next_disabled = true;
		$next_index = $n_index;
	}
	if($n_index - $limit >= 0){
		$prev_index = $n_index - $limit;
	}else{
		$prev_disabled = true;
		$prev_index = 0;
	}
?>

<div class="row" style="margin-top:20px;">
	<div class="col s1"></div>
	<div class="col s2">
	<?php if(!$prev_disabled): ?>
		<a class="btn btn-block color-purple waves-effect waves-light" href="<?=url()?>admin/data-view/<?=$table?>/<?=($prev_index==0)?'':$prev_index;?>">Prev</a>
	<?php endif; ?>
	</div>
	<div class="col s6"></div>
	<div class="col s2">
	<?php if(!$next_disabled): ?>
		<a class="btn btn-block color-purple waves-effect waves-light" href="<?=url()?>admin/data-view/<?=$table?>/<?=$next_index?>">Next</a>
	<?php endif; ?>
	</div>
	<div class="col s1"></div>
</div>

<div style="height:50px;"></div>