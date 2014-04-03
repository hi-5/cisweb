<?php

include "cislib.php";
include "connect.php";

global $sql;

$js = $_POST['js'];

$js = stripslashes($js);
$js = json_decode($js, true);

$order; //Sort Order
$year; //Year for report
$team; //Team ID num
$teamName; //Team Name
$report; //Report Name
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
$reportHeader = ""; //Holds the report header string for web
$csv = ""; //holds the csv string
$filename; //csv filename

$order = $js["order"];
$year = $js["year"];
$team = $js["team"];
$length = $js["length"];
$format = $js["format"];
$teamName = $js["teamName"];
$report = $js["report"];

//Do to limitations of the database we can not order based on YOE
if ($order == "YOE" || $order == "lastTeam") {
	echo "Sorry, but you can not order by that attribute";
	exit();	
} 

if ($report != "") $report .= ",";

$filename = $year . preg_replace("([^\w\s\d\-_~,;:\[\]\(\]]|[\.]{2,})", '', $teamName);

//Builder report header
$reportHeader = "<h1>University of Lethbridge $teamName</h1>\n<h2>$report $year - " . ($year+1) . "</h2>\n";
$csv .= "University of Lethbridge\n" .  $teamName . "\n" . $year . "-" . ($year+1) . "\n";


//Builder table header info and SQL select statement
for ($i = 0; $i < $length; $i++) {
	$name = $js["attributes"]["$i"]["name"];
	$head = $js["attributes"]["$i"]["header"];

	//Build select statement
	if ($name == "YOE" || $name == "lastTeam") {

	} elseif ($name == "athletes.a_studentId") {
	//we always want to select studentId for getting YOE so we dont add it to the query
	} else $select .= $name .= ", ";

	//Build column headers
	$header .= "<th>" . $head . "</th>";
	$csv .= $head . ",";

}

//remove trailing comma
$select = rtrim($select, ", ");

$csv .= "\n";

$query = "SELECT athletes.a_studentId, $select
FROM athletehistory
INNER JOIN athletes
ON athletehistory.ah_studentId=athletes.a_studentId
AND athletehistory.ah_year = $year
AND athletehistory.ah_teamId = $team
AND athletehistory.ah_institute = 'University of Lethbridge'
ORDER BY $order";



//start table
$table .= "<table class='table table-striped table-condensed'>\n";
$table .= "<thead>" . $header . "</thead>";

$result = mysqli_query($sql, $query);

//Holds athlete Year of Eligibility
$yoe;
while($row = mysqli_fetch_assoc($result)) {

	$table .= "<tr>";

	for ($i = 0; $i < $length; $i++) {
		//get attribute name
		$temp = $js["attributes"]["$i"]["name"];
		if ($temp == "lastTeam") {
			$attribute = $temp;
			$lastTeam = getLastTeamPlayed($row['a_studentId'], $sql);
			$table .= "<td>" . $lastTeam . "</td>";
			$csv .= $lastTeam . ",";
		} else if ($temp == "YOE") {
			$attribute = $temp;
			$yoe = getEligibility($row['a_studentId'], $sql);
			$table .= "<td>" . $yoe . "</td>";
			$csv .= $yoe . ",";
		} else {
			$temp = explode(".", $temp);
			$attribute = $temp[1];
			$table .= "<td>" . $row["$attribute"] . "</td>";
			$csv .= $row["$attribute"] . ",";	
		}

		
	}

	$table .= "</tr>\n";
	$csv .= "\n";
}


//close table
$table .= "</table>"; 

$html = "<html>
  <head>
    <title>$filename</title>
    <!-- style -->
    <link href='css/main.css' rel='stylesheet' />
    <!-- bootstrap framework -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <link href='//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css' rel='stylesheet' />
  </head>

  <body>

  $reportHeader
  $table

  </body>
</html>";

//Print HTML or File
if ($format == "web") {
	// echo $reportHeader;
	// echo $table;
	echo $html;
} elseif ($format == "excel") {
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=$filename.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$csv";
}




?>