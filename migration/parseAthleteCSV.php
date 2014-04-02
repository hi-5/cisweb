<?php

/********************************/
/* Code at http://legend.ws/blog/tips-tricks/csv-php-mysql-import/
/* Edit the entries below to reflect the appropriate values
/********************************/
$databasehost = "localhost";
$databasename = "cis";
$databasetable = "athletes";
$databaseusername ="mike";
$databasepassword = "onetwo";
$fieldseparator = ",";
$lineseparator = "\n";
$csvfile = "studentInfo.csv";
/********************************/
/* Would you like to add an ampty field at the beginning of these records?
/* This is useful if you have a table with the first field being an auto_increment integer
/* and the csv file does not have such as empty field before the records.
/* Set 1 for yes and 0 for no. ATTENTION: don't set to 1 if you are not sure.
/* This can dump data in the wrong fields if this extra field does not exist in the table
/********************************/
$addauto = 0;
/********************************/
/* Would you like to save the mysql queries in a file? If yes set $save to 1.
/* Permission on the file should be set to 777. Either upload a sample file through ftp and
/* change the permissions, or execute at the prompt: touch output.sql && chmod 777 output.sql
/********************************/
$save = 1;
$outputfile = "athletes.sql";
/********************************/


if(!file_exists($csvfile)) {
	echo "File not found. Make sure you specified the correct path.\n";
	exit;
}

$file = fopen($csvfile,"r");

if(!$file) {
	echo "Error opening data file.\n";
	exit;
}

$size = filesize($csvfile);

if(!$size) {
	echo "File is empty.\n";
	exit;
}

$csvcontent = fread($file,$size);

fclose($file);

$con = @mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
@mysql_select_db($databasename) or die(mysql_error());

$lines = 0;
$queries = "";
$linearray = array();

foreach(split($lineseparator,$csvcontent) as $line) {

	$lines++;

	$line = trim($line," \t");
	
	$line = str_replace("\r","",$line);
	
	/************************************
	This line escapes the special character. remove it if entries are already escaped in the csv file
	************************************/
	$line = str_replace("'","\'",$line);
	/*************************************/
	
	$linearray = explode($fieldseparator,$line);


	/***********************************
	Custom data formating code by Mike Paulson
	/********************************/

	//Parse date
	$date = array();
	$datestring = "";
	if (isset($linearray[4]) && $linearray[4] != "") {
		$date = explode("/", $linearray[4]);
		if (isset($date[2])) {
			$datestring = $date[2] . "-" . $date[0] . "-" . $date[1];
		}
		else {
			echo "Date error on ID" . $linearray[0] . "<br />";
		}


		$linearray[4] = $datestring;
	}


	//Parse Height
	$heightstring = "";
	if (isset($linearray[5]) && $linearray[5] != "") {

		$heightstring = $linearray[5];
		$heightstring = preg_replace("/[^0-9,.]/", "", $heightstring);
		$heightstring = substr_replace($heightstring, "''", 1, 0);
		if (strlen($heightstring) > 3) $heightstring = substr_replace($heightstring, "\\\"", strlen($heightstring), 0);

		$linearray[5] = $heightstring;
	}

	//Parse Weight
	$weightstring = "";
	if (isset($linearray[6]) && $linearray[6] != "") {

		$weightstring = $linearray[6];
		$weightstring = preg_replace("/[^0-9,.]/", "", $weightstring);

		$linearray[6] = $weightstring;
	}

	//Parse postal code
	if (isset($linearray[10])) {
		$linearray[10] = str_replace(' ', '', $linearray[10]);
		$linearray[10] = str_replace('-', '', $linearray[10]);
	}
	
	if (isset($linearray[15])) {
		$linearray[15] = str_replace(' ', '', $linearray[15]);
		$linearray[15] = str_replace('-', '', $linearray[15]);
	}

	//Parse province
	if (isset($linearray[15])) {
		$linearray[14] = preg_replace("/[^A-Za-z0-9 ]/", '', $linearray[14]);
	}



	//Make it test data
	//$linearray[1] = $linearray[0];

	/***********************************
	End of Custom data formating code
	/********************************/

	$linemysql = implode("','",$linearray);
	
	if($addauto)
		$query = "insert into $databasetable (a_studentId, a_lastName, a_firstName, a_gender, a_dob, a_height, a_weight, a_cStreet, a_cCity, a_cProvince, a_cPostalCode, a_cPhone, a_pStreet, a_pCity, a_pProvince, a_pPostalCode, a_pPhone, a_program, a_hometown) values('','$linemysql');";
	else
		$query = "insert into $databasetable (a_studentId, a_lastName, a_firstName, a_gender, a_dob, a_height, a_weight, a_cStreet, a_cCity, a_cProvince, a_cPostalCode, a_cPhone, a_pStreet, a_pCity, a_pProvince, a_pPostalCode, a_pPhone, a_program, a_hometown) values('$linemysql');";
	
	$queries .= $query . "\n";

	@mysql_query($query);
}

@mysql_close($con);

if($save) {
	
	if(!is_writable($outputfile)) {
		echo "File is not writable, check permissions.\n";
	}
	
	else {
		$file2 = fopen($outputfile,"w");
		
		if(!$file2) {
			echo "Error writing to the output file.\n";
		}
		else {
			fwrite($file2,$queries);
			fclose($file2);
		}
	}
	
}

echo "Found a total of $lines records in this csv file.\n";


?>
