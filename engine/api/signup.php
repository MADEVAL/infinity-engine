<?php
	if(isset($_POST["signup"])){
		$name = (isset($_POST["name"])) ? $_POST["name"] : ""; if($name == ""){$errors[] = "Name not valid.";}
		$username = (isset($_POST["username"])) ? $_POST["username"] : ""; if($username == ""){$errors[] = "Username not valid.";}
		$email = (isset($_POST["email"])) ? $_POST["email"] : ""; if($email == ""){$errors[] = "Email not valid.";}
		$password = (isset($_POST["password"])) ? $_POST["password"] : ""; if($password == ""){$errors[] = "Password not valid.";}
		$date_birth = (isset($_POST["date_birth"])) ? $_POST["date_birth"] : ""; if($date_birth == ""){$errors[] = "Date of Birth not valid.";}

		if(SiteSettings::get("USER_REGISTRATION") == "CLOSED") {$errors[] = "User Registration is closed.";}

		if(count($errors) == 0){

			$data_birth =  DateTime::createFromFormat("Y-m-d", $date_birth)->format(DATE_FORMAT);
			$level = 0;
			$security_code = rand(100000, 999999);

			$profile_picture = SiteSettings::get("DEFAULT_PROFILE_PICTURE");
			$status = SiteSettings::get("DEFAULT_USER_STATUS");
			$bio = "";
			$privacy = 0;
			$date_joined = date(DATE_FORMAT);

			if(strlen($name) > 100){ $errors[] = "Name is longer than 100 alphabets."; }
			if(strlen($username) > 100){ $errors[] = "Username is longer than 100 alphabets."; }
			if(strlen($email) > 100){ $errors[] = "Email is longer than 100 alphabets."; }
			if(strlen($password) > 100){ $errors[] = "Password is longer than 100 alphabets."; }

			$db = db();


			$query = $db->query("SELECT * FROM users WHERE username = '" . $db->real_escape_string($username) .  "'");
			if($query->num_rows > 0){
				$errors[] = "Username already exists.";
			}

			$query = $db->query("SELECT * FROM users WHERE email = '" . $db->real_escape_string($email) .  "'");
			if($query->num_rows > 0){
				$errors[] = "Email already registered.";
			}

			if(count($errors) == 0){
				$query = $db->prepare("INSERT INTO users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->bind_param("ssssissssiss", $name, $username, $email, $password, $level, $security_code, $profile_picture, $status, $bio, $privacy, $date_birth, $date_joined);
				$query->execute();
				if($query->affected_rows == 1){
					$success[] = "User has been created.";
					$insert_id = $db->insert_id;

					$to = $email;
					$subject = 'Sign Up Confirmation from ' . SiteSettings::get("SITE_TITLE");
					$message = 'Hey visit ' . url('admin/verify/' . $insert_id . "/" . $security_code) . " to confirm your registration.";
					$headers = 'From: Registrar <' . SiteSettings::get("REGISTRATION_EMAIL") . '>' . "\r\n" . 'Reply-To: ' . SiteSettings::get("REGISTRATION_EMAIL") . "\r\n";
					Notifier::notify("Howdy Mate", "Write your page now!", "account_circle", $insert_id);

					$whitelist = array('127.0.0.1', "::1");
					if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
						mail($to, $subject, $message, $headers);
					}

					if(!is_dir("content/user/" . user_folder($insert_id))){
						mkdir("content/user/" . user_folder($insert_id));
						mkdir("content/user/" . user_folder($insert_id) . "/files");
						file_put_contents("content/user/" . user_folder($insert_id) . "/files/index.php", "");
						file_put_contents("content/user/" . user_folder($insert_id) . "/forms/index.php", "");
						file_put_contents("content/user/" . user_folder($insert_id) . "/events/index.php", "");
						file_put_contents("content/user/" . user_folder($insert_id) . "/meta/index.php", "");
						file_put_contents("content/user/" . user_folder($insert_id) . "/thumbs/index.php", "");
						file_put_contents("content/user/" . user_folder($insert_id) . "/index.php", "");
					}
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