
<?php 
$working_theme = SiteSettings::get("WORKING_THEME");
$theme = ThemeAPI::settings(); 
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
			<h4>You are using the</h4>
			<h4 class="theme-name"><?=$name?> Theme <small>by <a href="<?=$author_url?>"><?=$author?></a></small></h4>

			<div class="row">
				<div class="col s4">
					<a href="#modal_theme_information">
						<div class="card card-button card-button-small color-purple tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Theme Details">
							<i class="material-icons">info</i>
						</div>
					</a>
				</div>
				<div class="col s4">
					<a target="_blank" href="<?=url()?>">
						<div class="card card-button card-button-small color-pink tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="View Site">
							<i class="material-icons">language</i>
						</div>
					</a>
				</div>
				<div class="col s4">
					<a href="<?=url('admin/theme-settings')?>">
						<div class="card card-button card-button-small color-blue tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Theme Settings">
							<i class="material-icons">settings_applications</i>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	#modal_theme_information .modal-content{
		padding-bottom: 0px !important;
	}
	#modal_theme_information .modal-footer{
		background: rgb(216,216,216)
	}
</style>
<div id="modal_theme_information" class="modal black-text">
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

<div class="divider"></div>
