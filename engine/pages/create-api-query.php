<?php
	if(isset($_POST["query_new"])){
		
		$db = db();

		$query_hash = substr(md5(rand(0, 10000) . "_" . time() .  rand(0 ,10000)), 0, 8);
		$query_code = $db->real_escape_string($_POST["query_code"]);
		$query_lock = '0';
		
		$user_id = $_SESSION["user"]["id"];
		$date_created = date(DATE_FORMAT);
		
		$query = "INSERT INTO api_queries VALUES (NULL, '$query_hash', '$query_code', '0', '$user_id' , '$date_created')";
		$db->query($query);
		echo $db->error;
		$db->close();

		echo "Query is now registered for use.";
		
	}
?>

<h5 style="text-align: center; font-weight: bolder;">
	Create a New Query
</h5>

<form method="post">
<div class="adminForm row">
	<div class="inputGroup">
		<div class="col s3 formLabel">
			Query Code
		</div>
		<div class="col s8">
			<input name="query_code" type="text" />
		</div>
	</div>

	<div class="btnGroup">
		<div class="col s3 formLabel">
		&nbsp;
		</div>
		<div class="col s8" style="text-align: center;">
			<input name="query_new" class="btn btn-block waves-block color-purple waves-effect waves-light" type="submit" value="Create" style="margin:0; margin-bottom:25px;" />
		</div>
	</div>

</div>
</form>