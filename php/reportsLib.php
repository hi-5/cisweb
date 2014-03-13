<?php

include "connect.php";

$action = $_POST['action'];
  switch ( $action ) {

    // add a report
    case 'add':
      addReport( $_POST['name'],  $_POST['string']);
      break;

    // delete a report
    case 'delete':
      deleteTeam( $_POST['args'] );
      break;

    // get list of report names
    case 'getList':
      getReports();
      break;

    //get the report JSON string
    case 'getString':
      getReportString( $_POST['id'] );
      break;
  }

  function addReport($name, $string) {
    global $sql;

    $name = mysql_real_escape_string($name);
    $string = mysql_real_escape_string($string);

    $query = "INSERT INTO reports (r_name, r_string) VALUES ('$name', '$string')";

    mysqli_query($sql, $query);

  }

  function getReports() {
    global $sql;

    $query = "SELECT r_id, r_name FROM reports";
    $result = mysqli_query($sql, $query);
  
    $reports = array();
    while($row = mysqli_fetch_assoc($result)) {
      $reports[] = $row;
    }

    print json_encode($reports);
  }

  function getReportString($id) {
    global $sql;

    $id = mysql_real_escape_string($id);

    $query = "SELECT r_string FROM reports WHERE r_id = $id";
    $result = mysqli_query($sql, $query);
    $result = mysqli_fetch_assoc($result);

    print json_encode($result);
  }

  ?>