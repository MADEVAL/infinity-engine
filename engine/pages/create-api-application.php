<div style="width: 70%; display: block; margin:auto;">
<?php
	if(isset($_POST["application_new"])){
		function str_replace_batch($replace, $substitute, $subject){
			foreach ($replace as $key) {
				$subject = str_replace($key, $substitute, $subject);
			}
			return $subject;
		}
		$batch_array = [" ", "`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]", "}", ";", ":", "'", '"', '<', '>', "?", "/", ".", ","];
		$db = db();
		$application_name = $db->real_escape_string($_POST["application_name"]);
		$application_hash = strtolower(str_replace_batch($batch_array, "", $application_name)) . '-' . substr(md5($application_name), 0, 16);
		$application_secret = substr(md5(rand(100000, 999999) . time() . "-application-" . $application_name), 0, 16);
		$user_id = $_SESSION["user"]["id"];
		$date_created = date(DATE_FORMAT);
		$db->query("INSERT INTO api_apps VALUES(NULL, '$application_name', '$application_hash', '$application_secret', '$user_id', '$date_created')");
		$db->close();
		echo "App has been created.";
	}
?>

<h5 style="text-align: center; font-weight: bolder;">
	Create a New Application
</h5>

<form method="post">
<div class="adminForm row">
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Name
		</div>
		<div class="col s8">
			<input name="application_name" type="text" />
		</div>
	</div>

	<div class="btnGroup" style="text-align: center;">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8" style="text-align: center;">
			<input name="application_new" class="btn btn-block waves-block color-purple waves-effect waves-light" type="submit" value="Create" style="margin:0; margin-bottom:25px;" />
		</div>
	</div>

</div>
</form>
</div>