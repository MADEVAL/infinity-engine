<?php
	if(isset($_POST["event_create"])){
		$event_name = (isset($_POST["event_name"])) ? $_POST["event_name"] : ""; if($event_name == ""){$errors[] = "Event Name not valid.";}
		$event_date = (isset($_POST["event_date"])) ? to_date($_POST["event_date"]) : ""; if($event_date == ""){$errors[] = "Event Date not valid.";}
		$event_scope = (isset($_POST["event_scope"])) ? $_POST["event_scope"] : ""; if($event_scope == ""){$errors[] = "Event Type not valid.";}
		if($event_scope > 2 and $_SESSION["user"]["level"] < 10){
			$errors[] = "Sorry, you cannot create site wise events.";
		}
		$event_reminder = (isset($_POST["event_reminder"])) ? $_POST["event_reminder"] : ""; if($event_reminder == ""){$errors[] = "Reminder not valid.";}
		$event_completion = 0;
		if(count($errors) == 0){
			$event_image = (isset($_FILES["event_image"])) ? $_FILES["event_image"] : ""; if($event_image == ""){$errors[] = "Image not valid.";}

			$user_folder = user_folder($_SESSION["user"]["id"]);
			if(!is_dir("content/user/" . $user_folder . "/" . "events")){ mkdir("content/user/" . $user_folder . "/" . "events"); }

			$upload_dir = "content/user/" . $user_folder . "/" . "events";
			$extension = array_pop(explode(".", $event_image["name"]));
			$jname = md5(microtime() . "_" . $_SESSION["user"]["id"]) . "." . $extension; // Just Name
			$fname = $upload_dir . "/" . $jname; // Full Name
			move_uploaded_file($event_image["tmp_name"], $fname);

			image_resize($fname, 640, 480, str_replace(".".$extension, '', $jname));

			$event_reminder = ($event_reminder == "on")? 1 : 0;

			$db = db();

			if(count($errors) == 0){
				$query = $db->prepare("INSERT INTO events VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->bind_param("ssisiiis", $event_name, $event_date, $event_scope, $fname, $event_reminder, $event_completion, $_SESSION["user"]["id"], date(DATE_FORMAT));
				$query->execute();
				if($query->affected_rows == 1){
					$success[] = "Event has been added to your Library.";
				}else{
					if($db->error != ""){
						$errors[] = $db->error;
					}
					if($query->error != ""){
						$errors[] = $query->error;
					}
				}
			}
			$db->close();
		}
	}

	if(count($errors) > 0){
		foreach ($errors as $error) {
			echo "<div class='card card-panel card-dark'>" . $error . "</div>";
		}
	}
	if(count($success) > 0){
		foreach ($success as $message) {
			echo "<div class='card card-panel card-dark'>" . $message . "</div>";
		}
	}