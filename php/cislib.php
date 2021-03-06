<?php

/*
  - this is the library file for php functions called by the manager files
  - contains all functions that are used by other functions
  -
  - File: cislib.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/

  // queries the database to determine the athletes current years charged and returns answer. Expects the athletes studentId and the sql.
  function getEligibility($studentId, $sql) {
    $query = "SELECT DISTINCT ah_charged, ah_year FROM athletehistory WHERE ah_studentId = ($studentId) AND ah_charged = 1";
    $result = mysqli_query($sql, $query);
    return $result->num_rows;
  }

  // Returns the last team a student played on that was not the U of L, expects a student ID num and the SQL
  function getLastTeamPlayed($id, $sql) {
    $query = "SELECT ah_teamName FROM athletehistory WHERE ah_studentId = $id AND ah_institute != 'University of Lethbridge' ORDER BY ah_year";
    $result = mysqli_query($sql, $query);

    $array = array();
    while($row = mysqli_fetch_assoc($result)) {
      return $row['ah_teamName'];
    }
    return "";

  }

  // calculates the number of years a coach had been the coach of a given team from the year given. Expects coach id num and team id num and the sql.
  function getYearsCoach($id, $tid, $year, $sql) {
    $query = "SELECT t_headCoachId FROM teams WHERE t_id = $tid AND t_headCoachId = $id AND t_year <= $year";
    $result = mysqli_query($sql, $query);
    return $result->num_rows;
  }

  // expects a student id and the sql connection. Returns true if the id is an admin.
  function isAdmin($id, $sql) {
    $query = "SELECT f_studentId FROM faculty WHERE f_studentId = $id AND f_isAdmin = 1";
    $result = mysqli_query($sql, $query);

    if($result->num_rows != 0) {
      return true;
    }
    else return false;
  }

  //Ensures the user is an admin, if not redirect to error page.
  function loggedAdmin() {
    if (!$_SESSION['isAdmin']) {
      header( 'Location: /pages/error.php' );
      die();
    }
  }

  //if user is a student and the regestration page is not their own, redirect to error page. Expects the ID of the student record being accessed
  function loggedStudent($id) {
    if (!$_SESSION['isAdmin']) {
      if ($id != $_SESSION['studentId']) {
        header( 'Location: /pages/error.php' );
        die();
      }
    }
  }

?>