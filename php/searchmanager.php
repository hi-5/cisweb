<?PHP

/*
  - This file is used in AJAX calls from the pages.
  - It contains a switch statement used to call various functions
  - for searching users and teams within the database.
  -
  - File: searchmanager.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/

  include "connect.php";
  include "cislib.php";

  session_start();
  loggedAdmin();

  $action = $_POST['action'];
  switch ( $action ) {

    // search athlete by last/first/id
    case 'getAthlete':
      getAthlete();
      break;

    // search teams by year
    case 'getTeam':
      getTeam();
      break;
  }

  //Gets athletes with names LIKE provided name
  function getAthlete() {
    global $sql;

    $searchText = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "SELECT a_studentId, a_lastName, a_firstName FROM athletes WHERE a_studentId LIKE '%$searchText%' OR a_lastName LIKE '%$searchText%' OR a_firstName LIKE '%$searchText%' ORDER BY a_lastName ASC LIMIT 20";
    $result = mysqli_query($sql, $query);

    $athletes = array("athletes");
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      $athletes[] = $row;
    echo json_encode($athletes);
  }

  //Gets teams with names LIKE provided name
  function getTeam() {
    global $sql;

    $searchText = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "SELECT t_id, t_year, t_name FROM teams WHERE t_year LIKE '%$searchText%'";
    $result = mysqli_query($sql, $query);
    
    $teams = array("teams");
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      $teams[] = $row;
    echo json_encode($teams);
  }
?>