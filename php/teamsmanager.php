<?php

  include "connect.php";

  $action = $_POST["action"];
  switch ($action) {

    // create new team
    case "createNewTeam":
      createNewTeam();
      break;

    // create new year
    case "createNewYear":
      createNewYear();
      break;

    // delete a team
    case "deleteTeam":
      deleteTeam();
      break;

    // get year list
    case "getYearList":
      getYearList();
      break;

    // get list of teams from specific year
    case "getTeamsByYear":
      getTeamsByYear();
      break;

    // get list of teams
    case "getDistinctTeamList":
      getDistinctTeamList();
      break;
  }

  function createNewTeam() {
    global $sql;
    $year = $_POST["args"]["year"];
    $name = $_POST["args"]["name"];

    // get next id to use
    $idQuery = "SELECT DISTINCT t_id FROM teams ORDER BY t_id DESC";
    $idResult = mysqli_query($sql, $idQuery);
    $nextId = mysqli_fetch_row($idResult)[0] + 1;  

    $query = "INSERT INTO teams (t_id, t_year, t_name) VALUES ($nextId, $year, '$name')";
    $result = mysqli_query($sql, $query);
    echo $result;
  }

  function createNewYear() {
    global $sql;

    $year = $_POST["args"];
    $query = "INSERT INTO teams (t_id, t_name, t_year, t_headCoachId, t_asstCoachId, t_managerId, t_trainerId, t_doctorId, t_therapistId) SELECT t_id, t_name, " . ($year + 1) . ", t_headCoachId, t_asstCoachId, t_managerId, t_trainerId, t_doctorId, t_therapistId FROM teams WHERE t_year = $year";
    $result = mysqli_query($sql, $query);
    echo $result;
  }

  function deleteTeam() {
    global $sql;

    $year = $_POST["args"]["year"];
    $id = $_POST["args"]["id"];
    $query = "DELETE FROM teams WHERE t_year = $year AND t_id = $id";
    $result = mysqli_query($sql, $query);
    echo $result;
  }

  function getYearList() {
    global $sql;

    $query = "SELECT DISTINCT t_year FROM teams ORDER BY t_year DESC";
    $result = mysqli_query($sql, $query);

    $yearData = array();
    while($row = mysqli_fetch_row($result))
      array_push($yearData, $row[0]);

    echo json_encode($yearData);
  }

  function getTeamsByYear() {
    global $sql;

    $year = mysqli_real_escape_string($sql, $_POST["args"]);
    $query = "SELECT t_id, t_name FROM teams WHERE t_year = $year ORDER BY t_id ASC";
    $result = mysqli_query($sql, $query);
    
    $teamData = array();
    while ($row = mysqli_fetch_assoc($result))
      $teamData[] = $row;

    print json_encode($teamData);
  }

  //Sends back an array of JSON objects for each team in the database
  function getDistinctTeamList() {
    global $sql;

    $query = "SELECT DISTINCT t_id, t_name FROM teams";
    $result = mysqli_query($sql, $query);
    
    $teamData = array();
    while($row = mysqli_fetch_assoc($result))
      $teamData[] = $row;

    print json_encode($teamData);
  }

?>