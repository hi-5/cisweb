<?php

include "../php/connect.php";

global $sql;

	$outputfile = "pastTeams.sql";
	$queries = "";

	$query = "SELECT DISTINCT athletehistory.ah_teamId, athletehistory.ah_year, teams.t_name
	FROM athletehistory
	INNER JOIN teams
	ON athletehistory.ah_teamId=teams.t_id
	AND athletehistory.ah_year != 0";

	$result = mysqli_query($sql, $query);

	$id = 0;
	$year = 0;
	$name = "";


	while($r = mysqli_fetch_assoc($result)) {
		$id = $r['ah_teamId'];
		$year = $r['ah_year'];
		$name = $r['t_name'];
		$name = str_replace("'","\'",$name);
		$queries .= "INSERT INTO teams (t_id, t_year, t_name) values ($id, $year, '$name');\n";
	}


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

	mysqli_close($sql);

	

?>

