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

?>