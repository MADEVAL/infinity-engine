<?php

	if(isset($_POST["imageUpload"])){
		if(isset($_FILES["image"])){
			$file = $_FILES["image"];
			$root = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/forms/";
			if(!is_dir($root)){mkdir($root);}
			$destination = $root . $file["name"];
			move_uploaded_file($file["tmp_name"], $destination);
			
			list($width, $height) = getimagesize($destination);
			$data["url"] = url() . $destination;
			$data["base_url"] = $destination;
			$data["size"] = [$width, $height];
		}
	}

	if(isset($_POST["imageRotate"])){
		$file_name = array_shift(explode("?", str_replace(url(), "", $_POST["url"])));
		$direction = $_POST["direction"];

		if($direction == 'CCW'){
			$degrees = 90;
		}else{
			$degrees = -90;
		}

		$source = imagecreatefromstring(file_get_contents($file_name));
		imagealphablending($source, false);
		imagesavealpha($source, true);

		$rotate =  imagerotate($source, $degrees, imageColorAllocateAlpha($source, 0, 0, 0, 127));
		imagealphablending($rotate, false);
		imagesavealpha($rotate, true);

		imagepng($rotate, $file_name);

		$data["url"] = url() . $file_name;
		$data["base_url"] = $file_name;

		imagedestroy($rotate);
		imagedestroy($source);
	}

	if(isset($_POST["imageSave"])){
		$file_name = array_shift(explode("?", str_replace(url(), "", $_POST["url"])));
		$croppable = true;
		list($width, $height) = getimagesize($file_name);
		if($croppable){
			$crop = explode(",", $_POST["crop"]);

			$image = imagecreatefromjpeg($file_name);
			
			$cropped = imagecrop($image, [
				'x'=>imagesx($image) * $crop[1],
				'y'=>imagesy($image) * $crop[0],
				'width'=>imagesx($image) * $crop[3] - imagesx($image) * $crop[1],
				'height'=>imagesy($image) * $crop[2] - imagesy($image) * $crop[0]
			]);

			imagejpeg($cropped, $file_name, 80);
		}
		list($width, $height) = getimagesize($file_name);
		$data["url"] = url() . $file_name;
		$data["size"] = [$width, $height];
	}