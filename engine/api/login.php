<?php
	if(isset($_POST["login"])){
		$username = (isset($_POST["username"])) ? $_POST["username"] : ""; if($username == ""){$errors[] = "Username not valid.";}
		$password = (isset($_POST["password"])) ? $_POST["password"] : ""; if($password == ""){$errors[] = "Password not valid.";}

		if(count($errors) == 0){

			if(strlen($username) > 100){ $errors[] = "Username is longer than 100 alphabets."; }
			if(strlen($password) > 100){ $errors[] = "Password is longer than 100 alphabets."; }

			if(count($errors) == 0){
				$db = db();

				$query = $db->prepare("SELECT * FROM users WHERE username=? OR email=?");
				$query->bind_param("ss", $username, $username);
				$result = $query->execute();
				$query->store_result();
				
				if($query->num_rows == 1){
					$result = array();
					stmt_bind_assoc($query, $result);
					while($query->fetch()){
						if($result["password"] == $password){
							
							if($result["level"] == 0){
								$errors[] = "User is not verified. Please verify using the link sent to your email.";
							}else{
								unset($result["password"]);
								unset($result["email"]);
								if($result["level"] == 1){
									$errors[] = "User is not allowed by any moderator.";
								}else{
									$_SESSION["user"] = $result;
									if(!is_dir("content/user/" . user_folder($_SESSION["user"]["id"]))){
										mkdir("content/user/" . user_folder($_SESSION["user"]["id"]));
									}
									$success[] = "User is logged in";
								}
							}
						}else{
							$errors[] = "User combination does not exist.";
						}
					}
				}else{
					$errors[] = "User combination does not exist.";
				}
				$db->close();
			}
		}
	}