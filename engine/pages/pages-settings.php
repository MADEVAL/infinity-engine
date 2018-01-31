
<h5 style="text-align:center;">Options</h5>
<?php
	if(isset($_POST["page_searchify"])){

		$db = db();
		$user_id = $_SESSION["user"]['id'];
		$theme = SiteSettings::get("WORKING_THEME");
		$db->query("DELETE FROM search");
		$query = $db->query("SELECT * FROM routes WHERE user_id=$user_id");
		while($route = $query->fetch_array()){
			$file = "content/pages/" . $route["file"];
			$xml = file_get_contents($file);
			$raw_data = preg_replace('/\s+/S', " ", strip_tags($xml));
			$raw_data_array = explode(" ", $raw_data);
			$words = array();
			foreach ($raw_data_array as $word) {
				if(trim($word) == ""){continue;}
				$word = trim($word);
				$word = str_replace("\n", "", $word);
				$word = str_replace("\t", "", $word);
				if(!in_array($word, $words)){
					$words[] = $word;
				}
			}
			$route_id = $route["id"];
			$word_cloud = implode(" ", $words);
			if(trim($word_cloud)!=""){
				$word_cloud = $db->real_escape_string($word_cloud);
				$db->query("INSERT INTO search VALUES (NULL, '$word_cloud', 1,'page','" . $route_id . "','" . date(DATE_FORMAT) . "')");
			}

		}
		$db->close();

		echo "<div class='message' onclick='$(this).remove()'>Researching Successful</div>";
	}
?>
<div class="row">
	<div class="col s2">
<style type="text/css">
	.menu-btn-design{
		height:97.125px;
		line-height:97.125px;
		text-transform: none;
	}
	.message{
		padding:6px;
		margin:6px;
		background:rgb(42,44,48);
		border-radius:4px;
		text-align: center;
		cursor: pointer;
	}
</style>
	<form method="post">
		<input name="page_searchify" class="btn btn-block btn-large color-dark waves-effect waves-block waves-light menu-btn-design" type="submit" value="Searchify" />
	</form>
	</div>
</div>