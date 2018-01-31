<h5 style="text-align: center; font-weight: bolder;">
	Applications
</h5>

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Title</td>
			<td>Description</td>
			<td>Options</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$db = db();
			$query = $db->query("SELECT * FROM boards");
			echo $db->error;
			$counter = 0;
			while($app = $query->fetch_assoc()):
				$counter++;
		?>
		<tr>
			<td><?=$counter?></td>
			<td><?=$app["board_title"]?></td>
			<td><b><?=$app["board_description"]?></b></td>
			<td>
				<a class="smallbtn delete_board" app_id="<?=$app["board_id"]?>" href="#">Delete</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		$(".delete_board").on("click", function(){
			board_id = $(this).attr("app_id");
			data = {
				"board_delete":board_id
			}
			clicked_element = $(this)
			$.post("<?=url()?>admin/apps/boards/api.php", data, function(resp){
				clicked_element.parent().parent().remove()
			})
		})
	})
</script>