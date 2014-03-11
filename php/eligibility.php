<?php



//Function queries the database to determine the athletes current years charged and returns answer. Expects the athletes studentId.
function getEligibility($studentId, $sql) {

	$eligQuery;
	$eligResult;
	$elig;

	$eligQuery = "SELECT DISTINCT ah_charged, ah_year FROM athletehistory WHERE ah_studentId = ($studentId) AND ah_charged = 1";

	$eligResult = mysqli_query($sql, $eligQuery);

	$elig = $eligResult->num_rows;

	return $elig;

}

?>