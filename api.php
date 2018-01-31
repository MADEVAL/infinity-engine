<?php
	define("INFINITY_ENGINE_API", "2.0.0");
	
	require "engine/system/init.php";
	
	header("Content-Type:application/json");
	
	$response = array(
		"errors" => [],
		"success" => []
	);

	$success = [];
	$errors = [];

	function str_replace_first($from, $to, $subject)
	{
		$from = '/'.preg_quote($from, '/').'/';
		return preg_replace($from, $to, $subject, 1);
	}


	if(isset($_POST["QUERY_HASH"]) and isset($_POST["APPLICATION_HASH"]) and isset($_POST["APPLICATION_SECRET"])){
		
		$db = db();

		$app = $db->real_escape_string($_POST["APPLICATION_HASH"]);

		$secret = $db->real_escape_string($_POST["APPLICATION_SECRET"]);

		$query = $db->real_escape_string($_POST["query"]);

		if(isset($_POST["result"]) and $_POST["result"] == true){
	
			$result = true;
	
		}else{
	
			$result = false;
	
		}
		
		if(isset($_POST["args"])){

			$args = $_POST["args"];
	
		}else{
		
			$args = [];
		
		}


		$query_hash = $db->real_escape_string($query);

		//$app_query = $db->query("SELECT * FROM api_apps WHERE hash = '$app'");

		$query = $db->query("SELECT * FROM api_queries WHERE query_hash = '$query_hash'");


		if($query->num_rows == 1){

			$query = $query->fetch_assoc();

			$code = $query["query_code"];

			if($query["query_lock"] == '0'){

				foreach($args as $arg){

					$code = str_replace_first("?", $arg, $code);

				}

				/* Execution of Query */

				$query = $db->query($code);

				if($result == true){

					$assoc = [];

					while($item = $query->fetch_assoc()){
						$assoc[] = $item;
					}

					$response["result"] = $assoc; 
				}

				$success = true;

			}else{

				$errors[] = "Query is locked from use.";

			}


		}else{

			$errors[] = $query->num_rows . " queries were found";

		}

		$db->close();

	}

	$response["success"] = $success;
	$response["errors"] = $errors;

	echo json_encode($response);