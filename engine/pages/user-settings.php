<?php echo '<script type="text/javascript">document.title = "User Settings - Infinity Engine"</script>'; ?>
<style type="text/css">
	.adminForm .inputGroup  input, .adminForm .inputGroup .inputFile{
		border:1px solid rgb(50,58,60);
		border-radius: 4px;
		padding-left:25px;
	}
	.adminForm .inputGroup .inputFile{
		height:50px !important;
		line-height:50px !important;
		width: 100%;
		display: block;
		position: relative;
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

<h4 class="text-center">Your Profile</h4>
<br />
<?php
	$editable_settings = array("name", "email",  "password", "status", "bio");
	$dividers = array();
	$db = db();
?>

<?php
	if(isset($_POST["page_submit"])){
		foreach ($editable_settings as $editable_setting) {
			if(isset($_POST[$editable_setting])){
				$value = $_POST[strtolower($editable_setting)];
				$value = $db->real_escape_string($value);
				$query = $db->query("UPDATE users SET $editable_setting='$value' WHERE id=" . $_SESSION["user"]["id"]);
			}
		}
	}
	$query = $db->query("SELECT * FROM users WHERE id=" . $_SESSION["user"]["id"]);
	$user = $query->fetch_assoc();
	$db->close();
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
			<input name="<?=$editable_setting;?>" type="text" value="<?=$user[$editable_setting];?>" />
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

<?php

if(isset($_POST["page_upload"])){
	if(isset($_FILES["propic"])){
		$file = $_FILES["propic"];
		$image_path = "content/user/" . user_folder($user["id"]) . "/profile.jpg";
		move_uploaded_file($file['tmp_name'], $image_path);
		list($width, $height) = getimagesize($image_path) ;
		$tn = imagecreatetruecolor($width, $height) ;
		$image = imagecreatefromstring(file_get_contents($image_path)) ;
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height) ; 
		imagejpeg($tn, $image_path,80) ;
		$resize = new resize($image_path);
		$resize->resizeImage(512,512, 'crop');
		$resize->saveImage($image_path);
		$db = db();
		$image_name = $db->real_escape_string($image_path);
		$db->query("UPDATE users SET profile_picture='$image_name' WHERE id=".$user["id"]);
		$query = $db->query("SELECT * FROM users WHERE id=".$user["id"]);
		$result = $query->fetch_assoc();
		unset($result["password"]);
		unset($result["email"]);
		$_SESSION["user"] = $result;
		$db->close();
	}
	echo '<script type="text/javascript">window.location.href = window.location.pathname;</script>';
}

?>
<form method="post" enctype="multipart/form-data">
<div class="adminForm row">
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Profile Picture
		</div>
		<div class="col s7">
			<input class="inputFile" name="propic" type="file" required />
		</div>
		<div class="col s2">
			<div class="card">
				<div class="card-image">
					<img class="responsive-img" src="<?=url().$user["profile_picture"]?>">
					<span class="card-title" style="text-shadow:0px 0px 5px rgb(0,0,0); font-size:14px; font-weight:bolder;">Current</span>
				</div>
			</div>
		</div>
	</div>
	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input name="page_upload" class="btn color-purple waves-effect waves-light" type="submit" value="Upload" />
		</div>
	</div>
</div>
</form>