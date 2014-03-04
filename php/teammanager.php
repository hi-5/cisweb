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
      updateTeam( $_POST['args'], $_POST['name'] );
      break;

    // get list of account names
    case 'list':
      sendTeamList();
      break;
  }

//Sends back an array of JSON objects for each team in the database
function sendTeamList() {

	global $sql;

	$query = "SELECT t_id, t_name FROM teams";

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

	$query = "INSERT INTO teams (t_name) VALUES ('$args')";

	mysqli_query($sql, $query);

	mysqli_close($sql);

}

//Deletes a team with the id $arg from the database
function deleteTeam($args) {
  global $sql;

  $query = "DELETE FROM teams WHERE t_id = ('$args')";

  mysqli_query($sql, $query);

  mysqli_close($sql);

}

//Updates team name with id $arg in the database
function updateTeam($args, $name) {
  global $sql;

  $query = "UPDATE teams SET t_name = ('$name') WHERE t_id = ('$args')";

  mysqli_query($sql, $query);

  mysqli_close($sql);

}

?>