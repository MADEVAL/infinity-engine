<style type="text/css">
.custom-highlight td{
	text-align: center;
}
.custom-highlight tr:hover{
	background: rgb(48,50,52);
	box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.1);
}
</style>
<table class="custom-highlight">
	<tbody>
	<?php
			$database = new DatabaseStructure();
			$database->generate();
			$structure = $database->structure;
			$database->release();
			$counter = 1;
			foreach ($structure as $table):
				if(Data::is_table($table)):
		?>
		<tr>
			<td><?=$counter?>.</td>
			<td><?php 
			if(!Data::is_table_data($table, "title"))
				echo ucwords(str_replace("_", " ", $table));
			else
				echo Data::get_table_data($table, "title");
			?>
			<?php
			if(Data::is_table_data($table, "description")):
			?>
			<small style="color:rgb(159,164, 170);"><?php echo Data::get_table_data($table, "description") ?></small>
			<?php
			endif;
			?>
			</td>
			<td width="20%">
				<?php
					if(Data::is_table_permission($table, DATA_INSERT)):
				?>
				<a class="btn waves-effect waves-light color-purple btn-floating" href="<?=url()?>admin/data-insert/<?=$table?>">
					<i class="material-icons">add</i>
				</a>
				<?php
					endif;
				?>
				<?php
					if(Data::is_table_permission($table, DATA_VIEW)):
				?>
				<a class="btn waves-effect waves-light color-pink btn-floating" href="<?=url()?>admin/data-view/<?=$table?>">
					<i class="material-icons">assignment</i>
				</a>
				<?php
					endif;
				?>
				<?php
					if(Data::is_table_permission($table, DATA_DOWNLOAD)):
				?>
				<a class="btn waves-effect waves-light color-blue btn-floating" href="<?php echo url("data-download.php?table=" . $table)?>">
					<i class="material-icons">file_download</i>
				</a>
				<?php
					endif;
				?>
			</td>
		</tr>
		<?php 
			$counter += 1;
			endif;
			endforeach;
		?>
	</tbody>
</table>
<script type="text/javascript">
	function download_table(table){
		data = {downloadTable:table}
		$.ajax({
			url:"<?=url()?>admin/api/downloadTable",
			type:"POST",
			data:data,
			success: function(r){
				console.log(r)
			},
			error:function(e){
				console.log(e)
			}
		})
	}
</script>