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
      deleteReport( $_POST['args'] );
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

    $string = stripslashes($string);

    $name = mysqli_real_escape_string($sql, $name);
    $string = mysqli_real_escape_string($sql, $string);

    echo $name;
    echo $string;

    $query = "INSERT INTO reports (r_name, r_string) VALUES ('$name', '$string')";

    mysqli_query($sql, $query);

  }

  function deleteReport($args) {
    global $sql;

    $obj = json_decode($args);
    $id = $obj->id;

    $query = "DELETE FROM reports WHERE r_id = $id";

    mysqli_query($sql, $query);
    
    print json_encode("success");
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

    $id = mysqli_real_escape_string($sql, $id);

    $query = "SELECT r_string FROM reports WHERE r_id = $id";
    $result = mysqli_query($sql, $query);
    $result = mysqli_fetch_assoc($result);

    print json_encode($result);
  }

  ?>