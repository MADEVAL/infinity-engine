<?php echo '<script type="text/javascript">document.title = "Theme Settings - Infinity Engine"</script>'; ?>
<style type="text/css">
	.adminForm .inputGroup  input{
		border:1px solid rgb(50,58,60);
		border-radius: 4px;
		padding-left:25px;
	}
	.adminForm .inputGroup  .switch{
		line-height:46px;
	}
	.adminForm .btnGroup .btn{
		margin-top:30px;
	}
	.adminForm .btnGroup .btn:focus{
		outline: none !important;
	}
	.adminForm .inputGroup  input:focus{
		border:1px solid rgb(80,83,85) !important;
		outline: 0px !important;
		box-shadow: 0px 0px 0px 0px transparent !important;
	}
	.adminForm .inputGroup  input:hover{
		border:1px solid rgb(80,83,85) !important;
		outline: 0px !important;
		box-shadow: 0px 0px 0px 0px transparent !important;
	}
	.adminForm .inputGroup  .formLabel{
		text-align: right;
		line-height:46px;
	}
</style>

<h4 class="text-center">Theme Settings</h4>
<br />
<?php
	$theme = ThemeApi::settings();
	$editable_settings = array();
	$dividers = array();
	if(isset($theme["settings"])){
		foreach ($theme["settings"] as $option) {
			array_push($editable_settings, $option);
		}
	}

	if(isset($_POST["page_submit"])){
		foreach ($editable_settings as $editable_setting) {
			$rawopt = $editable_setting;
			$editable_setting = $rawopt->key;

			if(isset($_POST[strtolower(str_replace(" ", "_", $editable_setting))])){
				$value = $_POST[strtolower(str_replace(" ", "_", $editable_setting))];
				ThemeSettings::set($editable_setting, $value, true);
				if(ThemeSettings::get($editable_setting) == $value){
					//pass
				}else{
					echo "$editable_setting was not saved.";
				}
			}
		}
	}
?>
<form method="post">
<div class="adminForm row">
	<?php
		foreach ($editable_settings as $editable_setting):
			$rawopt = $editable_setting;
			$editable_setting = $rawopt->key;
			$type = $rawopt->type;
	?>
	<div class="inputGroup">
		<div class="col s3 formLabel">
			<?=ucfirst(str_replace("_", " ", strtolower($editable_setting)));?>
		</div>
		<div class="col s8">
			<?php 
			$value = "";
				$dbval = ThemeSettings::get($editable_setting); if($dbval == -1){
				foreach ($theme["settings"] as $opt) {
					if($opt->key == $editable_setting){
						$value = $opt->default;
					}
				}
				}else $value = ThemeSettings::get($editable_setting);
			if($type == 10): ?>
			<select class="browser-default black-text" name="<?=strtolower(str_replace(" ", "_", $editable_setting));?>">
				<option value="" disabled>Choose your option</option>
				<?php
					foreach ($theme["pages"] as $page):
				?>
				<option <?php if($page->file == $value) echo "selected"; ?> value="<?=$page->file;?>"><?=$page->title;?></option>
				<?php endforeach; ?>
			</select>
			<?php else: ?>
			<input name="<?=strtolower(str_replace(" ", "_", $editable_setting));?>" type="<?php
				if($type == 0){echo "text";}else
				if($type == 1){echo "number";}else
				if($type == 2){echo "date";}else
				if($type == 3){echo "email";}else
				if($type == 10){echo "text";}
			?>" value="<?=$value?>" />
			<?php endif; ?>
		</div>
	</div>
	<br>
	<br>
	<br>

	<?php
	if(in_array($editable_setting, $dividers)):
	?>
	<div class="divider"></div>
	<?php endif; ?>
	<?php 
		endforeach; 
	?>
	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input name="page_submit" class="btn color-purple waves-effect waves-light" type="submit" value="Save" />
		</div>
	</div>
</div>
</form>