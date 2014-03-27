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

  // Update roster eligibility
  case 'updateEligibility' :
    updateEligibility( $_POST['args'] );
    break;

  //Get faculty IDs for team
  case 'getFaculty' :
    getFaculty( $_POST['args'] );
    break;

  //Update all faculty on team
  case 'saveFaculty' :
    saveFaculty( $_POST['args'] );
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

    $obj = json_decode($args);

    $year = $obj->year;
    $team = $obj->team;

    $table = "";

    $query = "SELECT athletes.a_studentId, athletes.a_lastName, athletes.a_firstName, athletehistory.ah_position, athletehistory.ah_jerseyNumber, athletehistory.ah_charged
      FROM athletehistory
      INNER JOIN athletes
      ON athletehistory.ah_studentId=athletes.a_studentId
      AND athletehistory.ah_year = $year
      AND athletehistory.ah_teamId = $team
      ORDER BY athletes.a_lastName";

    $result = mysqli_query($sql, $query);

    $roster = array();
    while($row = mysqli_fetch_assoc($result)) {
      $roster[] = $row;
    }

    print json_encode($roster);

  }

  //Takes an array of student IDs, a charged value (1 or 0) and a year. Updates all students with given IDs and years
  function updateEligibility($args) {
    global $sql;

    $array = json_decode($args, true);
    $length = count($array);
    $id;
    $val;
    $year;
    $query;

    for ($i=0; $i < $length; $i++) { 
      $id = $array[$i][0];
      $val = $array[$i][1];
      $year = $array[$i][2];

      $query = "UPDATE athletehistory 
      SET ah_charged=$val 
      WHERE ah_studentId=$id 
      AND ah_year=$year";

      mysqli_query($sql, $query);

    }

    print json_encode("success");

  }

  //Returns the IDs for all faculty on a team in the given year and team id.
  function getFaculty($args) {
    global $sql;

    $obj = json_decode($args);

    $year = $obj->year;
    $team = $obj->team;

    $query = "SELECT t_headCoachId, t_asstCoachId, t_trainerId, t_doctorId, t_therapistId 
    FROM teams 
    WHERE t_year = $year 
    AND t_id = $team";

    $result = mysqli_query($sql, $query);

    $row = mysqli_fetch_assoc($result);

    print json_encode($row);

  }

  function saveFaculty($args) {
    global $sql;

    $obj = json_decode($args);

    $query = "UPDATE teams
    SET t_headCoachId=$obj->coach, t_asstCoachId=$obj->assCoach, t_trainerId=$obj->trainer, t_doctorId=$obj->doctor, t_therapistId=$obj->therapist 
    WHERE t_year = $obj->year 
    AND t_id = $obj->team";

    // echo $query;

    mysqli_query($sql, $query);

    print json_encode("success");
  }

?>