<?php

	if(isset($_POST["direct_upload"])){
		$counter = 0;
		$total = count($_FILES['file']['name']);
		for ($i=0; $i < $total; $i++) {
			$counter = $i;
			$file = $_FILES["file"];
			$folder_name = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/";
			if(!is_dir($folder_name)){
				mkdir($folder_name);
			}
			$upload_name = $folder_name . $file["name"][$counter];
			move_uploaded_file($file["tmp_name"][$counter], $upload_name);
			$success[] = "Uploaded " . $file["name"][$counter];
		}
	}