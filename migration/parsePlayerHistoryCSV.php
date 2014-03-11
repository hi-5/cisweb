<?php

/********************************/
/* Code at http://legend.ws/blog/tips-tricks/csv-php-mysql-import/
/* Edit the entries below to reflect the appropriate values
/********************************/
$databasehost = "localhost";
$databasename = "cis";
$databasetable = "athletehistory";
$databaseusername ="mike";
$databasepassword = "onetwo";
$fieldseparator = ",";
$lineseparator = "\n";
$csvfile = "playerHistory.csv";
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
$outputfile = "athletehistory.sql";
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
	$year = 0;
	$yearstr = "";
	if (isset($linearray[2]) && $linearray[2] != "") {
		$yearstr = $linearray[2];
		$yearstr = substr($yearstr, 0, 4);
		$linearray[2] = $yearstr;
	}

	$charged = 0;
	if (isset($linearray[6]) && $linearray[6] != "") {
		if ($linearray[6] == "TRUE") $charged = 1;
		else $charged = 0;
		$linearray[6] = $charged;
	}


	/***********************************
	End of Custom data formating code
	/********************************/

	$linemysql = implode("','",$linearray);
	
	if($addauto)
		$query = "insert into $databasetable (ah_studentId, ah_teamId, ah_year, ah_jerseyNumber, ah_position, ah_teamName, ah_charged) values('','$linemysql');";
	else
		$query = "insert into $databasetable (ah_studentId, ah_teamId, ah_year, ah_jerseyNumber, ah_position, ah_teamName, ah_charged) values('$linemysql');";
	
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
