<?php

/*
  - This file is used in AJAX calls from the pages.
  - It contains a switch statement used to call various functions
  - for CRUD proccesses associated with the reports table.
  -
  - File: reportsmanager.php
  - Author: Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/


include "connect.php";
include "cislib.php";

session_start();

//Stops non-admins from executing any code in this document
loggedAdmin();
if (!$_SESSION['isAdmin']) {
  die();
}

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

  //Adds a report to the database
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

  //Deletes a report of the given ID from the database.
  function deleteReport($args) {
    global $sql;

    $obj = json_decode($args);
    $id = $obj->id;

    $query = "DELETE FROM reports WHERE r_id = $id";

    mysqli_query($sql, $query);
    
    print json_encode("success");
  }

  //Gets a list of all saved reports.
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

  //Gets the report string of the given report ID
  function getReportString($id) {
    global $sql;

    $id = mysqli_real_escape_string($sql, $id);

    $query = "SELECT r_string FROM reports WHERE r_id = $id";
    $result = mysqli_query($sql, $query);
    $result = mysqli_fetch_assoc($result);

    print json_encode($result);
  }

  ?>