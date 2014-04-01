<?php

  function getCurrentYear() {
    // calculate the current year and return it here
    return 2013;
  }

  // queries the database to determine the athletes current years charged and returns answer. Expects the athletes studentId and the sql.
  function getEligibility($studentId, $sql) {
    $query = "SELECT DISTINCT ah_charged, ah_year FROM athletehistory WHERE ah_studentId = ($studentId) AND ah_charged = 1";
    $result = mysqli_query($sql, $query);
    return $result->num_rows;
  }

  // calculates the number of years a coach had been the coach of a given team from the year given. Expects coach id num and team id num and the sql.
  function getYearsCoach($id, $tid, $year, $sql) {
    $query = "SELECT t_headCoachId FROM teams WHERE t_id = $tid AND t_headCoachId = $id AND t_year <= $year";
    $result = mysqli_query($sql, $query);
    return $result->num_rows;
  }

?>