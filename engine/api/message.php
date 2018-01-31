<?php

if(isset($_POST["message_log"])){
	$current_user_id = $_POST["sender_user"];	
	$my_user_id = $_SESSION["user"]["id"];
	$index = $_POST["index"];

	$errors[] = "index not set";

	$db = db();
	$query = $db->query("SELECT * FROM messages WHERE (send_id = $my_user_id AND recv_id = $current_user_id) OR (send_id = $current_user_id AND recv_id = $my_user_id) ORDER BY id DESC LIMIT 0, 10");
	
	$messages = [];
	while($message = $query->fetch_assoc()){
		$messages[] = $message;
	}

	$success["messages"] = $messages;

	$db->close();
}

if(isset($_POST["message_send"])){
	$current_user_id = $_POST["sender_user"];
	$my_user_id = $_SESSION["user"]["id"];
	$message = $_POST["message"];

	$attachment = '';
	$message_type = 0;
	$time = time();
	$date_created = date(DATE_FORMAT);

	$db = db();
	$query = $db->query("INSERT INTO messages VALUES(NULL, '$my_user_id', '$current_user_id', '$message', '$attachment', '$message_type', '$time', '$date_created')");
	$db->close();
}