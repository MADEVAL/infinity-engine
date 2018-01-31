<?php

if(isset($_POST["searchData"])){
	$search = $_POST["searchData"];

	$db = db();

	$like_string = "";
	$search_data = explode(" ", $db->real_escape_string($search));

	$query = $db->query("SELECT * FROM search WHERE word_cloud LIKE '%" . $like_string . "%' LIMIT 10");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			if($row["link_type"]=="page"){
				$query2 = $db->query("SELECT * FROM routes WHERE id = " . $row["link_id"]);
				if($query2->num_rows > 0){
					$row["link"] = $query2->fetch_assoc();
				}
			}
			$data[] = $row;
		}
	}

	$db->close();

	$success["time"] = time();
}
