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

  // get list of teams
  case 'getList':
    getTeamList();
    break;

  // get list of teams from specific year
  case 'getYear':
    getYear();
    break;
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

  //Sends back an array of JSON objects for each team in the database
  function getTeamList() {
    global $sql;

    $query = "SELECT DISTINCT t_id, t_name FROM teams";
    $result = mysqli_query($sql, $query);
    
    $teams = array();
    while($row = mysqli_fetch_assoc($result)) {
      $teams[] = $row;
    }

    mysqli_close($sql);
    print json_encode($teams);
  }

  function getYear() {
    global $sql;

    $year = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "SELECT t_id, t_name FROM teams WHERE t_year = $year";
    $result = mysqli_query($sql, $query);
    
    $teams = array();
    while ($row = mysqli_fetch_assoc($result))
      $teams[] = $row;

    mysqli_close($sql);
    print json_encode($teams);
  }

?>