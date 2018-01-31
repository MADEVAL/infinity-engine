<?php echo '<script type="text/javascript">document.title = "Pages - Infinity Engine"</script>'; ?>

<style type="text/css">
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
	.highlight-custom tr{
		transition:all 0.2s ease;
		border-radius: 20px !important;
	}
	.highlight-custom tr:hover{
		background:rgb(48,48,48);
	}
</style>
<div style="display: inline; float:right; margin-top:15px;">
	<a class="dropdown-button" data-activates='dropdown_newfile' href="#">
		<div class="btn btn-floating color-purple tooltipped waves-effect waves-block" data-position="left" data-tooltip="New page">
			<i class="material-icons">add</i>
		</div>
	</a>
	<ul id='dropdown_newfile' class='dropdown-content'>
		<?php
			if(isset($theme_settings["pages"])){
				foreach ($theme_settings["pages"] as $page) {
					if(is_a($page, "Theme_Divider")){
						?>
							<li class="divider"></li>
						<?php
						continue;
					}
				?>
					<li><a target="_blank" href="<?=url()?>admin/page/<?=$page->file;?>"><i class="material-icons"><?=$page->icon;?></i> <?=$page->title;?></a></li>
		<?php	}
			}
		?>
	</ul>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.dropdown-button').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrainWidth: false, // Does not change width of dropdown to that of the activator
			hover: false, // Activate on hover
			gutter: btn_width, // Spacing from edge
			belowOrigin: false, // Displays dropdown below the button
			alignment: 'left', // Displays dropdown with edge aligned to the left of button
			stopPropagation: false // Stops event propagation
		});
	})
	</script>
</div>
<h4 style="text-align:center;">
	Pages
</h4>


<div class="container-fluid">
	<table class="responsive-table highlight-custom">
		<thead>
			<tr>
				<th>Index</th>
				<th>Title</th>
				<th>Route</th>
				<th>Date Created</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
<?php
	$db = db();
	$query = $db->query("SELECT * FROM routes WHERE template='" . SiteSettings::get("WORKING_THEME") . "' AND user_id=" . $_SESSION["user"]["id"] . " ORDER BY id DESC");
	if($query->num_rows>0){
		$counter = 1;
		while($route = $query->fetch_assoc()){
?>

			<tr>
				<td><?=$counter++?></td>
				<td><?=$route["title"]?></td>
				<td><a class="blue-text" href="<?=url(ltrim($route['route'], '/'))?>" target="_blank"><?=$route["route"]?></a></td>
				<td><?=$route["date_created"]?></td>
				<td>
					<a class="smallbtn" href="<?=url()?>admin/edit/<?=$route["id"]?>">Edit</a>
					<a class="smallbtn" href="<?=url()?>admin/delete/<?=$route["id"]?>">Delete</a>
				</td>
			</tr>

<?php
		}
	}else{
?>
			<tr>
				<td></td>
				<td></td>
				<td>Sorry no pages were found on your profile linked with the theme.</td>
				<td></td>
				<td></td>
			</tr>
<?php
	}
	$db->close();
?>

		</tbody>
	</table>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('.tooltipped').tooltip({delay: 50});
		$('.dropdown-button').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrainWidth: false, // Does not change width of dropdown to that of the activator
			hover: false, // Activate on hover
			//gutter: 0, // Spacing from edge
			belowOrigin: false, // Displays dropdown below the button
			stopPropagation: false // Stops event propagation
		});
	})
</script>

<div style="height:20px;"></div>

<?php require "engine/pages/divider.php"; ?>
<?php require "engine/pages/menus.php"; ?>
<?php require "engine/pages/divider.php"; ?>
<?php require "engine/pages/pages-settings.php"; ?>