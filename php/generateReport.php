<?php

include "connect.php";
include "eligibility.php";

global $sql;

$js = $_POST['js'];

$js = stripslashes($js);
$js = json_decode($js, true);

$order; //Sort Order
$year; //Year for report
$team; //Team ID num
$name; //table attribute name
$head; //table attribute description
$length; //number of attributes
$format; //output format, web or excel
$header = ""; //string holder the header for the table
$select = ""; //string for select statement
$query; //sql query
$table = ""; //holds the table string for web output
$result; //holds the main SQL query result
$attribute; //holds the current attribute name

$order = $js["order"];
$year = $js["year"];
$team = $js["team"];
$length = $js["length"];
$format = $js["format"];


//Builder table header info and SQL select statement
for ($i = 0; $i < $length; $i++) {
	$name = $js["attributes"]["$i"]["name"];
	$head = $js["attributes"]["$i"]["header"];

	//Build select statement
	if ($name == "YOE") {

	} elseif ($name == "athletes.a_studentId") {
		//we always want to select studentId for getting YOE so we dont add it to the query
	} else $select .= $name .= ", ";

	//Build table header for web output
	if ($format == "web") {
		$header .= "<th>" . $head . "</th>";
	}
}

//remove trailing comma
$select = rtrim($select, ", ");

$query = "SELECT athletes.a_studentId, $select
FROM athletehistory
INNER JOIN athletes
ON athletehistory.ah_studentId=athletes.a_studentId
AND athletehistory.ah_year = $year
AND athletehistory.ah_teamId = $team
ORDER BY $order";



//start table
$table .= "<table class='table table-striped'>\n";
$table .= "<thead>" . $header . "</thead>";

$result = mysqli_query($sql, $query);

while($row = mysqli_fetch_assoc($result)) {

	$table .= "<tr>";

	for ($i = 0; $i < $length; $i++) {
		//get attribute name
		$temp = $js["attributes"]["$i"]["name"];
		if ($temp != "YOE") {
			$temp = explode(".", $temp);
			$attribute = $temp[1];
			$table .= "<td>" . $row["$attribute"] . "</td>";
		} else {
			$attribute = $temp;
			$table .= "<td>" . getEligibility($row['a_studentId'], $sql) . "</td>";
		}

		
	}

	$table .= "</tr>\n";
}


//close table
$table .= "</table>"; 

echo $table;

?>