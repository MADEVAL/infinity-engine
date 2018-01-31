<?php echo '<script type="text/javascript">document.title = "Themes - Infinity Engine"</script>'; ?>

<div class="text-center">
	<h4 style="font-weight:bolder; margin-bottom:20px;">All Themes</h4>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#theme_activate").on("click", function(e){
			e.preventDefault();
			data = {
				themeUpdate:$("#theme_activate").attr("theme"),
			}
			$.post("<?=url()?>" + "admin/api", data, function(resp){
				location.reload();
			})
		})
	});
</script>

<?php
	$current_working_theme = SiteSettings::get("WORKING_THEME");
	$theme_glob = array_filter(glob("content/themes/*"), "is_dir");
	$counter = 0;
	foreach ($theme_glob as $theme_dir):
		$theme = str_replace("content/themes/", "", $theme_dir);
		$counter ++;
?>

<?php 
$working_theme = $theme;
$theme = ThemeAPI::settings($working_theme); 
if(isset($theme["name"])){
	$name = $theme["name"];
}else{
	$name = "Unknown";
}
if(isset($theme["nickname"])){
	$nickname = $theme["nickname"];
}else{
	if(isset($theme["name"])){
		$nickname = $theme["name"];
	}else{
		$nickname = "Unknown";
	}
}
if(isset($theme["screenshot"])){
	$screenshot = url("content/themes/" . $working_theme . "/" . $theme["screenshot"]->file_name);
}else{
	$screenshot = url("assets/infinity-engine/theme-screenshot.png");
}
if(isset($theme["description"])){
	$description = $theme["description"];
}else{
	$description = "Unknown";
}
if(isset($theme["author"])){
	$author = $theme["author"];
}else{
	$author = "Unknown";
}
if(isset($theme["author_url"])){
	$author_url = $theme["author_url"];
}else{
	$author_url = "#";
}
if(isset($theme["theme_url"])){
	$theme_url = $theme["theme_url"];
}else{
	$theme_url = "#";
}

// name, nickname, screenshot, author, author_url
?>


<div class="row">
	<div class="col s6">
		<div class="card card-glow-image-text">
			<div class="card-image">
				<img class="responsive-img" src="<?=$screenshot?>">
				<span class="card-title"><?=$nickname?></span>
			</div>
		</div>
	</div>
	<div class="col s6">
		<div class="theme-information-card">
			<h4 class="theme-name"><?=$name?> Theme <br><small><a href="<?=$author_url?>"><?=$author?></a></small></h4>

			<div class="row">
				<div class="col s4">
					<a href="#modal_theme_information<?=$counter?>">
						<div class="card card-button card-button-small color-purple tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Theme Information">
							<i class="material-icons">info</i>
						</div>
					</a>
				</div>
				<?php
					if($current_working_theme != $working_theme):
				?>
				<div class="col s4">
					<a id="theme_activate" theme="<?=$working_theme;?>" href="#">
						<div class="card card-button card-button-small color-pink tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Activate">
							<i class="material-icons">vpn_key</i>
						</div>
					</a>
				</div>
				<?php else: ?>
				<div class="col s4">
					<a onclick="Materialize.toast('Theme is already active.')" href="#">
						<div class="card card-button card-button-small color-pink tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Already Active" style="cursor:not-allowed;">
							<i class="material-icons">check</i>
						</div>
					</a>
				</div>
				<div class="col s4">
					<a href="<?=url()?>admin/theme-settings">
						<div class="card card-button card-button-small color-blue tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Theme Settings">
							<i class="material-icons">settings_applications</i>
						</div>
					</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	#modal_theme_information<?=$counter?> .modal-content{
		padding-bottom: 0px !important;
	}
	#modal_theme_information<?=$counter?> .modal-footer{
		background: rgb(216,216,216)
	}
</style>
<div id="modal_theme_information<?=$counter?>" class="modal black-text">
	<div class="modal-content">
		<div class="row">
			<div class="col s6">
				<img class="responsive-img" src="<?=$screenshot?>">
			</div>
			<div class="col s6">
				<h4><a href="<?=$theme_url?>"><?=$name?></a></h4>
				<p><?=$description?></p>
				<br>
				<p>Made By <a class="blue-text" href="<?=$author_url?>"><?=$author?></a></p>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
	</div>
</div>

<?php endforeach; ?>