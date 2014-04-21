<?php

/*
  - This file is used in AJAX calls from the pages.
  - It contains a switch statement used to call various functions
  - for managing the eligibility status and faculty of a team.
  -
  - File: teammanager.php
  - Author: Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/

  include "connect.php";
  include "cislib.php";

  session_start();
  loggedAdmin();

  $action = $_POST['action'];
  switch ($action) {

    // get team roster information
    case 'getRosterTable' :
      getRosterTable();
      break;

    // update roster eligibility
    case 'updateEligibility' :
      updateEligibility();
      break;

    // get faculty IDs for team
    case 'getFaculty' :
      getFaculty();
      break;

    // update all faculty on team
    case 'saveFaculty' :
      saveFaculty();
      break; 
  }

  //Gets a roster for the given team
  function getRosterTable() {
    global $sql;

    $args = $_POST['args'];
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
      AND athletehistory.ah_institute = 'University of Lethbridge'
      ORDER BY athletes.a_lastName";

    $result = mysqli_query($sql, $query);

    $roster = array();
    while($row = mysqli_fetch_assoc($result)) {
      $roster[] = $row;
    }

    print json_encode($roster);

  }

  //Takes an array of student IDs, a charged value (1 or 0) and a year. Updates all students with given IDs and years
  function updateEligibility() {
    global $sql;

    $args = $_POST['args'];
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
  function getFaculty() {
    global $sql;

    $args = $_POST['args'];
    $obj = json_decode($args);

    $year = $obj->year;
    $team = $obj->team;

    $query = "SELECT t_headCoachId, t_asstCoachId, t_managerId, t_trainerId, t_doctorId, t_therapistId 
    FROM teams 
    WHERE t_year = $year 
    AND t_id = $team";

    $result = mysqli_query($sql, $query);

    $row = mysqli_fetch_assoc($result);

    print json_encode($row);

  }

  //Updates faculty ID numbers in the team record
  function saveFaculty() {
    global $sql;

    $args = $_POST['args'];
    $obj = json_decode($args);

    $query = "UPDATE teams
    SET t_headCoachId=$obj->coach, t_asstCoachId=$obj->assCoach, t_managerId=$obj->manager, t_trainerId=$obj->trainer, t_doctorId=$obj->doctor, t_therapistId=$obj->therapist 
    WHERE t_year = $obj->year 
    AND t_id = $obj->team";

    // echo $query;

    mysqli_query($sql, $query);

    print json_encode("success");
  }

?>