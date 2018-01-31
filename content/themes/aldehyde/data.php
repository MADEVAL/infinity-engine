<?php
	function alpha_date_created(){
		return date(DATE_FORMAT);
	}
	function beta_genre($arg){
		return $arg;
	}
	$data = array(
		"movies"=> array(
			"title"=>"My Films",
			"description"=>"All of  your movies",
			"permissions"=> [DATA_VIEW, DATA_EDIT, DATA_INSERT, DATA_REMOVE, DATA_DOWNLOAD],
			"columns" => array(
				"id"=>array(
					"type"=>"none", // text, number, none
					"display"=>"text", // text, link, image, none
					"default"=>"NULL",
					"stringify" => false,
				),
				"date_created"=>array(
					"alpha"=>"alpha_date_created",
				),
				"genre"=>array(
					"beta"=>"beta_genre",
				),
				"image_cover_url"=>array(
					"display"=>"image"
				),
				"omdb_url"=>array(
					"display"=>"link"
				),
				"embed_code"=>array(
					"display"=>"link"
				),
				"release_date"=>array(
					"type"=>"none", // text, number, none
				)
			),
			"default_column"=>array(
				"stringify" => true,
				"type"=>"text", // text, number, none
				"display"=>"text", // text, link, image, none
				"default"=>"",
				"truncate"=>50
			)
		)
	);