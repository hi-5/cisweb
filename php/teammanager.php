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

  // get team roster information
  case 'getRosterTable' :
    getRosterTable( $_POST['args'] );
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

}

//Updates team name with id $arg in the database
function updateTeam($args, $name) {
  global $sql;

  $query = "UPDATE teams SET t_name = ('$name') WHERE t_id = ('$args')";

  mysqli_query($sql, $query);

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

    print json_encode($teams);
  }

  function getRosterTable($args) {
    global $sql;

    $year = $args;;
    $team;
    $table = "";

    $query = "SELECT athletes.a_studentId, athletes.a_lastName, athletes.a_firstName, athletehistory.ah_position, athletehistory.ah_jerseyNumber, athletehistory.ah_charged
      FROM athletehistory
      INNER JOIN athletes
      ON athletehistory.ah_studentId=athletes.a_studentId
      AND athletehistory.ah_year = $year
      AND athletehistory.ah_teamId = 1
      ORDER BY athletes.a_lastName";

    $result = mysqli_query($sql, $query);

    $roster = array();
    while($row = mysqli_fetch_assoc($result)) {
      $roster[] = $row;
    }

    print json_encode($roster);

    // $table .= "<table class='table table-striped table-condensed'>\n";
    // $table .= "<theader><th>ID</th><th>Last Name</th><th>First Name</th><th>Position</th><th>Jersey No.</th><th>Charged</th></theader>";

    // while($row = mysqli_fetch_assoc($result)) {

    //   $table .= "<tr>";

    //   $table .= "<td>" . $row["a_studentId"] . "</td>";
    //   $table .= "<td>" . $row["a_lastName"] . "</td>";
    //   $table .= "<td>" . $row["a_firstName"] . "</td>";
    //   $table .= "<td>" . $row["ah_position"] . "</td>";
    //   $table .= "<td>" . $row["ah_jerseyNumber"] . "</td>";
    //   $table .= "<td>" . $row["ah_charged"] . "</td>";

    //   $table .= "</tr>\n";
    // }

    // $table .= "</table>\n";

    // print $table;

  }

?>