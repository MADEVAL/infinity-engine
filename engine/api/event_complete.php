<?php

	if(isset($_POST["event_complete"])){
		$db = db();
		$event_id = $db->real_escape_string($_POST["event_id"]);
		$db->query("UPDATE events SET event_completion = 1 WHERE event_id = " . $event_id);
		$success[] = "Event Completed. It has been removed from your library!";
		$db->close();
	}

	if(isset($_POST["query_lock"])){
		$query_lock = $_POST["query_lock"];
		$db = db();
		$query = $db->query("SELECT query_lock, query_id FROM api_queries WHERE query_id='$query_lock'")->fetch_assoc();
		$current_query_lock = $query["query_lock"];
		$error[] = $db->error;
		$new_query_lock = ( $current_query_lock == '0')? '1' : '0';
		$success_message = ( $current_query_lock == '0')? 'Query is enabled for use' : 'Query is locked from use';
		$db->query("UPDATE api_queries SET query_lock = $new_query_lock WHERE query_id=" . $query["query_id"]);
		$error[] = $db->error;
		$db->close();
		$success[] = $success_message;
	}

	if(isset($_POST["query_delete"])){
		$query_lock = $_POST["query_delete"];
		$db = db();
		$query = $db->query("SELECT * FROM api_queries WHERE query_id='$query_lock'")->fetch_assoc();
		$success_message = "";
		if($query["user_id"] == $_SESSION["user"]["id"]){
			$db->query("DELETE FROM api_queries WHERE query_id='$query_lock'");
			$success_message = "Query was deleted";
		}else{
			$success_message = "Query was not registered by you. Only registrars can delete query.";
		}
		$db->close();
		$success[] = $success_message;
	}

	if(isset($_POST["application_delete"])){
		$appid = $_POST["application_delete"];
		$db = db();
		$query = $db->query("SELECT * FROM api_apps WHERE id='$appid'")->fetch_assoc();
		$success_message = "";
		if($query["user_id"] == $_SESSION["user"]["id"]){
			$db->query("DELETE FROM api_apps WHERE id='$appid'");
			$success_message = "Query was deleted.";
		}else{
			$success_message = "Query was not registered by you. Only registrars can delete query.";
		}
		$db->close();
		$success[] = $success_message;
	}