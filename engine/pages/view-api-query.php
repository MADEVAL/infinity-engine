<style type="text/css">
	
</style>

<?php
	function querize($query){
		$query = str_replace("?", "<span class='animate-text'>?</span>", $query);
		return $query;
	}
?>

<h5 style="text-align: center; font-weight: bolder;">
	Custom Queries
</h5>

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Hash</td>
			<td>SQL Code</td>
			<td>Lock</td>
			<td>Options</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$db = db();
			$query = $db->query("SELECT * FROM api_queries");
			echo $db->error;
			$counter = 0;
			while($app = $query->fetch_assoc()):
				$counter++;
		?>
		<tr>
			<td><?=$counter?></td>
			<td><?=$app["query_hash"]?></td>
			<td><b><?=querize($app["query_code"])?></b></td>
			<td>
				<p>
					<input type="checkbox" query_id="<?=$app["query_id"]?>" class="filled-in query_lock" id="filled-in-box" <?php
						if($app["query_lock"] != '0'){
							echo "checked='checked'";
						}
					?> />
					<label for="filled-in-box"></label>
				</p>
			</td>
			<td>
				<?php
					if($app["user_id"] == $_SESSION["user"]["id"]):
				?>
				<a class="smallbtn delete_query" query_id="<?=$app["query_id"]?>" href="#">Delete</a>
				<?php 
					endif; 
				?>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$(".query_lock").on("click", function(){
			data = {
				query_lock: $(this).attr("query_id")
			}
			$.post("<?=url()?>admin/api/event_complete", data, function(r){
				Materialize.toast(r.success[0]);
			})
		})
		$(".delete_query").on("click", function(){
			data = {
				query_delete: $(this).attr("query_id")
			}
			$.post("<?=url()?>admin/api/event_complete", data, function(r){
				Materialize.toast(r.success[0]);
				location.reload()
			})
		})
		$(".delete_app").on("click", function(e){
			e.preventDefault();
			data = {
				application_delete: $(this).attr("app_id")
			}
			$.post("<?=url()?>admin/api/event_complete", data, function(r){
				Materialize.toast(r.success[0]);
				location.reload()
			})
		})
	})
</script>