<?php

include "connect.php";

$action = $_POST['action'];
  switch ( $action ) {

    // add an account
    case 'add':
      addTeam( $_POST['args'] );
      break;

    // delete an account
    case 'delete':
      deleteTeam( $_POST['args'] );
      break;

    // update an account
    case 'update':
      updateTeam( $_POST['args'] );
      break;

    // get list of account names
    case 'list':
      sendTeamList();
      break;
  }

//Sends back an array of JSON objects for each team in the database
function sendTeamList() {

	global $sql;

	$query = "SELECT t_id, t_description FROM teams";

	$result = mysqli_query($sql, $query);

	$rows = array();

	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r;
	}

	print json_encode($rows);

	mysqli_close($sql);
}

//Adds a team with the name $arg into the database
function addTeam($args) {

	global $sql;

	$query = "INSERT INTO teams (t_description) VALUES ('$args')";

	mysqli_query($sql, $query);

	mysqli_close($sql);

}

?>