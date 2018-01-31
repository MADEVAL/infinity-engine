<?php echo '<script type="text/javascript">document.title = "Website Settings - Infinity Engine"</script>'; ?>

<h4 class="text-center">Website Settings</h4>
<br />
<?php
	$editable_settings = array("SITE_TITLE", "SITE_DESCRIPTION", "SITE_TAGLINE", "DEFAULT_USER_STATUS", "DEFAULT_PROFILE_PICTURE", "SITE_TITLE_PREFIX", "SITE_TITLE_SUFFIX");
	$dividers = array("SITE_TAGLINE", "DEFAULT_PROFILE_PICTURE");
?>

<?php
	if(isset($_POST["page_submit"])){
		foreach ($editable_settings as $editable_setting) {
			if(isset($_POST[strtolower($editable_setting)])){
				$value = $_POST[strtolower($editable_setting)];
				SiteSettings::set($editable_setting, $value);
			}
		}
	}
?>
<form method="post">
<div class="adminForm row">
	<?php
		foreach ($editable_settings as $editable_setting):
	?>
	<div class="inputGroup">
		<div class="col s3 formLabel">
			<?=ucwords(str_replace("_", " ", strtolower($editable_setting)));?>
		</div>
		<div class="col s8">
			<input name="<?=strtolower($editable_setting);?>" type="text" value="<?=SiteSettings::get($editable_setting);?>" />
		</div>
	</div>

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