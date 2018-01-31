<?php

	header("Content-Type:application/json");

	$data = array();
	$errors = array();
	$success = array();

	require "api/signup.php";
	require "api/login.php";
	require "api/event_complete.php";
	require "api/direct_upload.php";
	require "api/newPage.php";
	require "api/createMenu.php";
	require "api/themeUpdate.php";
	require "api/page_edit.php";
	require "api/searchData.php";
	require "api/imageUpload.php";
	require "api/downloadTable.php";
	require "api/message.php";

	echo json_encode(array(
		"data"=>$data,
		"errors"=>$errors,
		"success"=>$success
	));