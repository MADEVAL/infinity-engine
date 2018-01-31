<?php

if(isset($_POST["page_edit"])){
		$db = db();
		$title = $db->real_escape_string($_POST["page_title"]);
		$route = $db->real_escape_string($_POST["page_route"]);
		$_tags = json_decode($_POST["page_tags"]);
		$tags = [];
		foreach ($_tags as $tag){
			$tags[] = $tag;
		}
		$tags = implode(" ", $tags);
		$page_id = $db->real_escape_string($_POST["page_id"]);
		$query = $db->query("SELECT * FROM routes WHERE route='$route' AND template='" . SiteSettings::get("WORKING_THEME") . "'");
		$id = $query->fetch_assoc()["id"];
		if($query->num_rows == 0){
			if(isset($_POST["page_public"])){
				$public = ($_POST["page_public"] == "on")?1:0;
			}else{
				$public = 0;
			}
			$query = $db->query("UPDATE routes SET tags = '" . $tags . "', title='" . $title . "', route='" . $route . "', is_public='" . $public . "' WHERE id='" . $page_id . "' ");
			echo "<script>Materialize.toast('Page Saved!')</script>";
		}else{
			if(isset($_POST["page_public"])){
				$public = ($_POST["page_public"] == "on")?1:0;
			}else{
				$public = 0;
			}
			$query = $db->query("UPDATE routes SET tags = '" . $tags . "', title='" . $title . "', is_public='" . $public . "' WHERE id='" . $page_id . "' ");
			if($id== $page_id){
				$success[] = "Updated.";
			}else{
				$errors[] = "Updated.";
			}
		}
	}