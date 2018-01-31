<?php echo '<script type="text/javascript">document.title = "Page Editor - Infinity Engine"</script>'; ?>
<?php
if(count($url) > 0){
	$db = db();
	$page_id = $db->real_escape_string(array_shift($url));

	if(isset($_POST["page_submit"])){
		$title = $db->real_escape_string($_POST["page_title"]);
		$route = $db->real_escape_string($_POST["page_route"]);
		$query = $db->query("SELECT * FROM routes WHERE route='$route' AND template='" . SiteSettings::get("WORKING_THEME") . "'");
		$id = $query->fetch_assoc()["id"];
		if($query->num_rows == 0){
			if(isset($_POST["page_public"])){
				$public = ($_POST["page_public"] == "on")?1:0;
			}else{
				$public = 0;
			}
			$query = $db->query("UPDATE routes SET title='" . $title . "', route='" . $route . "', is_public='" . $public . "' WHERE id='" . $page_id . "' ");
			echo "<script>Materialize.toast('Page Saved!')</script>";
		}else{
			if(isset($_POST["page_public"])){
				$public = ($_POST["page_public"] == "on")?1:0;
			}else{
				$public = 0;
			}
			$query = $db->query("UPDATE routes SET title='" . $title . "', is_public='" . $public . "' WHERE id='" . $page_id . "' ");
			if($id== $page_id){
				echo "<script>Materialize.toast('Page Saved!')</script>";
			}else{
				echo "<script>Materialize.toast('Route was already taken!')</script>";
			}
		}
	}
	$query = $db->query("SELECT * FROM routes WHERE id='$page_id'");
	if($query->num_rows == 1){
		$route = $query->fetch_assoc();
?>

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
	}.adminForm .inputGroupChipper  .formLabel{
		text-align: right;
		line-height:46px;
	}
	.adminForm .inputGroupChipper .chips{
		color:white;
		border:1px solid rgb(50,58,60);
		border-radius: 4px;
		padding-left:25px;
	}
	.adminForm .inputGroupChipper .chips:focus, .adminForm .inputGroupChipper .chips.focus, .adminForm .inputGroupChipper .chips:hover{
		border:1px solid rgb(80,83,85) !important;
		outline: 0px !important;
		box-shadow: 0px 0px 0px 0px transparent !important;
	}
	.adminForm .inputGroupChipper .chips input{
		color:white;
	}
</style>

<h4 class="text-center">Page Details</h4>
<br />

<form id="mainForm" method="post">
<div class="adminForm row">
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Title
		</div>
		<div class="col s8">
			<input id="page_title" type="text" value="<?=$route["title"]?>" />
		</div>
	</div>
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Route
		</div>
		<div class="col s8">
			<input id="page_route" type="text" value="<?=$route["route"]?>" />
		</div>
	</div>
	<div class="inputGroupChipper">
		<div class="col s3 formLabel">
			Tags
		</div>
		<div class="col s8">
			<div id="tagChips" name="tagChips" class="chips chips-placeholder"></div>
		</div>
	</div>
	<?php
		$tags =  explode(" ", $route["tags"]);
		$outcloud = [];
		foreach ($tags as $tag) {
			$outcloud[] = array("tag"=>$tag);
		}
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#tagChips').material_chip({
			data: <?php echo json_encode($outcloud); ?>,
			placeholder: '+Tag',
			secondaryPlaceholder: 'Enter a tag',
		});
	})
	</script>
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Public
		</div>
		<div class="col s8">
			<div class="switch">
				<label>
					Off
					<input id="page_public" type="checkbox" <?php echo ($route["is_public"])?"checked":""; ?>>
					<span class="lever"></span>
					On
				</label>
			</div>
		</div>
	</div>
	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input id="pageCreate" name="page_submit" class="btn color-purple waves-effect waves-light" type="submit" value="Save" />
			<a class="btn color-purple waves-effect waves-light" target="_blank" href="<?php echo url(ltrim($route["route"], "/")) ?>">Visit</a>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#pageCreate").on("click",function(e){
			e.preventDefault();
			form = $("#mainForm").serialize();
			var formData = new FormData();
			chipDataRaw = $('#tagChips').material_chip('data');
			chipData = []
			for (var i = 0; i < chipDataRaw.length; i++) {
				chipData.push(chipDataRaw[i].tag)
			};
			formData.append("page_title", $("#page_title").val())
			formData.append("page_route", $("#page_route").val())
			formData.append("page_public", $("#page_public").val())
			formData.append("page_tags",  JSON.stringify(chipData))
			formData.append("page_id", "<?=$page_id?>")
			formData.append("page_edit", $("#page_submit").val())
			window.fd =formData;
			$.ajax({
				url:"<?=url()?>admin/api/edit_page",
				data:formData,
				type:'POST',
				processData: false,
				contentType: false,
				success:function(r){
					Materialize.toast("Page has been updated.");
				},
				error:function(r){
					Materialize.toast("An error occurred.");
				}
			})

		})
	})
</script>

<?php
	}else{
		$errorTitle = "Request Page not Found";
		$errorMessage = "The URL does not comply to the algorithms.";
		require "error.php";
	}
	$db->close();
}else{
	$errorTitle = "Faulty URL";
	$errorMessage = "The URL does not comply to the algorithms.";
	require "error.php";
}
?>



<br />
<br />

<h5 class="text-center">Page Data</h5>
<br />

<?php 

$working_theme = ThemeApi::settings();
$settings = [];
$working_page = null;
foreach($working_theme["pages"] as $page){
	if(str_replace(" ", "_", strtolower($page->file)) == str_replace(" ", "_", strtolower($route["page"]))){
		$working_page = $page;
		$settings = $page->settings;
	}
};

?>

<?php
	if(isset($_POST["settings_save"])){
		$query_build = "";
		$update_keys = [];
		$update_vals = [];
		$insert_build = "";
		$db = db();
		foreach ($settings as $option){
			$post_key = "settings_" . str_replace(" ", "_", strtolower($option->key));
			if(isset($_POST[$post_key])){
				$opt_key = $option->key;
				$opt_value = $_POST[$post_key];
				$update_keys[] = $opt_key;
				$update_vals[] = $db->real_escape_string($opt_value);
				$insert_build .= "INSERT INTO settings_page VALUES(NULL, '$opt_key', '" . $db->real_escape_string($opt_value) . "', $page_id); ";
			}
		}
		$query_build = rtrim($query_build, ",");
		$query = $db->query("SELECT * FROM settings_page WHERE route='$page_id'");
		if($query->num_rows > 0){
			$row = $query->fetch_array();
			for ($i=0; $i < count($update_keys); $i++) { 
				$c_node = $update_keys[$i];
				$c_value = $update_vals[$i];
				$db->query("UPDATE settings_page SET value='$c_value' WHERE node='$c_node' AND route='$page_id'");
			}
			echo "<div class='message' onclick='$(this).remove()'>Settings were updated.</div>";
		}else{
			$insertion_queries = explode(";", $insert_build);
			foreach ($insertion_queries as $insertion_query) {
				if(trim($insertion_query) != "")
				$db->query($insertion_query);
			}
			echo "<div class='message' onclick='$(this).remove()'>Settings were saved.</div>";
		}
		$db->close();
	}
?>
<style type="text/css">
	.message{
		padding:6px;
		margin:6px;
		background:rgb(42,44,48);
		border-radius:4px;
		text-align: center;
		cursor: pointer;
	}
</style>
<form id="settingsForm" method="post">
<div class="adminForm row">

	<?php
		foreach ($settings as $option):
	?>
	<?php
		$key = $option->key;
		$db = db();
		$query = $db->query("SELECT * FROM settings_page WHERE node='$key' AND route='$page_id'");
		$defaultValue = $option->default;
		$rdefault = $defaultValue;
		if($query->num_rows == 1){
			$row = $query->fetch_array();
			$defaultValue = $row["value"];
		}
		$db->close();
	?>
	<div class="row inputGroup">
		<div class="col s3 formLabel">
			<?=$key;?>
		</div>
		<div class="col s8">
			<input id="label" name="settings_<?=str_replace(" ", "_", strtolower($key))?>" type="text" value="<?=$defaultValue?>" placeholder="<?=$rdefault?>" />
		</div>
	</div>
	
	<?php endforeach; ?>


	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8">
			<input name="settings_save" class="btn color-purple waves-effect waves-light" type="submit" value="Save" />
		</div>
	</div>
</div>
</form>