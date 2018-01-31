<h5 style="text-align: center; font-weight: bolder;">
	Applications
</h5>

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Application Name</td>
			<td>Hash</td>
			<td>Secret</td>
			<td>Options</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$db = db();
			$query = $db->query("SELECT * FROM api_apps");
			echo $db->error;
			$counter = 0;
			while($app = $query->fetch_assoc()):
				$counter++;
		?>
		<tr>
			<td><?=$counter?></td>
			<td><?=$app["name"]?></td>
			<td><b><?=$app["hash"]?></b></td>
			<td><b><?=$app["secret"]?></b></td>
			<td>
				<a class="smallbtn delete_app" app_id="<?=$app["id"]?>" href="#">Delete</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>