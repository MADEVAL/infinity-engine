<?php

require "engine/system/init.php";

if(isset($_SESSION["user"])){

	function setExcelContentType() {
		if(headers_sent())
			return false;

		header('Content-type: application/vnd.ms-excel');
		return true;
	}

	function setDownloadAsHeader($filename) {
		if(headers_sent())
			return false;

		header('Content-disposition: attachment; filename=' . $filename);
		return true;
	}

	function csvFromResult2($stream, $result, $showColumnHeaders = true) {
		if($showColumnHeaders) {
			$columnHeaders = array();
			$nfields = $result->num_rows;
			for($i = 0; $i < $nfields; $i++) {
				$field = $result->fetch_assoc();
				$columnHeaders = array_keys($field);
				$columnVals = array_values($field);
			}
			fputcsv($stream, $columnHeaders);
			fputcsv($stream, $columnVals);
		}

		$nrows = 0;
		while($row = $result->fetch_assoc()) {
			$columnVals = array_values($field);
			fputcsv($stream, $columnVals);
			$nrows++;
		}

		return $nrows + 1;
	}
	function array_format($arr){
		$a = [];
		foreach ($arr as $i) {
			$a[] = ucwords(str_replace("_", " ", $i));
		}
		return $a;
	}
	function csvFromResult($stream, $result, $s) {
		$columnHeaders = array();
		$columnValsAll = [];
		$nrows = 0;
		while($row = $result->fetch_assoc()) {
			$columnHeaders = array_keys($row);
			$columnValsAll[] = array_values($row);
			$nrows++;
		}
		fputcsv($stream, array_format($columnHeaders));
		foreach ($columnValsAll as $columnVals) {
			fputcsv($stream, $columnVals);
		}

		return $nrows;
	}

	function csvFileFromResult($filename, $result, $showColumnHeaders = true) {
		$fp = fopen($filename, 'w');
		$rc = csvFromResult($fp, $result, $showColumnHeaders);
		fclose($fp);
		return $rc;
	}

	function csvToExcelDownloadFromResult($result, $showColumnHeaders = true, $asFilename = 'data.csv') {
		setExcelContentType();
		setDownloadAsHeader($asFilename);
		return csvFileFromResult('php://output', $result, $showColumnHeaders);
	}

	$db = db();
	
	$table = $db->real_escape_string($_GET["table"]);


	if(Data::is_table_permission($table, DATA_DOWNLOAD) == 1){
		$result = $db->query("SELECT * FROM " . $table . ";");
		csvToExcelDownloadFromResult($result, true,  $table . '.csv');
	}

}