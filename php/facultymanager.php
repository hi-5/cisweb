<!--
  - This file is used in AJAX calls from the pages.
  - It contains a switch statement used to call various functions
  - for CRUD proccesses associated with the faculty table.
  -
  - File: facultymanager.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
-->

<?php

  include "connect.php";
  include "cislib.php";

//Security check
  session_start();
  loggedAdmin();

  $action = $_POST['action'];
  switch ( $action ) {

    // get list of faculty
    case 'getList':
      getList();
      break;

    // add faculty
    case 'add':
      add();
      break;

    // delete faculty
    case 'delete':
      delete();
      break;

    // update faculty
    case 'update':
      update();
      break;

    // get team faculty for given year
    case 'getTeam':
      getTeam();
      break;

    // Get name and id for all faculty
    case 'getAll' :
      getAll();
      break;
  }

  //Gets a list of faculty that start with the given letter
  function getList() {
    global $sql;

    $letter = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "SELECT f_studentId, f_lastName, f_firstName, f_phone, f_email, f_isAdmin FROM faculty WHERE f_lastName LIKE '$letter%' ORDER BY f_lastName ASC";
    $result = mysqli_query($sql, $query);
    
    $faculty = array();
    while($row = mysqli_fetch_assoc($result))
      $faculty[] = $row;

    mysqli_close($sql);
    echo json_encode($faculty);
  }

  //Adds a faculty member to the database
  function add() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $lastName = mysqli_real_escape_string($sql, $_POST['args']['lastName']);
    $firstName = mysqli_real_escape_string($sql, $_POST['args']['firstName']);
    $phone = mysqli_real_escape_string($sql, $_POST['args']['phone']);
    $email = mysqli_real_escape_string($sql, $_POST['args']['email']);
    $isAdmin = mysqli_real_escape_string($sql, $_POST['args']['isAdmin']);

    $query = "INSERT INTO faculty VALUES ($studentId, '$lastName', '$firstName', '$phone', '$email', $isAdmin)";
    $result = mysqli_query($sql, $query);

    echo $result; 
  }

  //Deletes a faculty member from the database
  function delete() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']);

    $query = "DELETE FROM faculty WHERE f_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result; 
  }

  //Updates a faculty member in the database
  function update() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $lastName = mysqli_real_escape_string($sql, $_POST['args']['lastName']);
    $firstName = mysqli_real_escape_string($sql, $_POST['args']['firstName']);
    $phone = mysqli_real_escape_string($sql, $_POST['args']['phone']);
    $email = mysqli_real_escape_string($sql, $_POST['args']['email']);
    $isAdmin = mysqli_real_escape_string($sql, $_POST['args']['isAdmin']);

    $query = "UPDATE faculty SET f_studentId = $studentId, f_lastName = '$lastName', f_firstName = '$firstName', f_phone = '$phone', f_email = '$email', f_isAdmin = $isAdmin WHERE f_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result; 
  }

  //Gets a list of all faculty in the database
  function getAll() {
    global $sql;

    $query = "SELECT f_studentId, f_lastName, f_firstName FROM faculty ORDER BY f_lastName";
    $result = mysqli_query($sql, $query);

    $faculty = array();
    while($row = mysqli_fetch_assoc($result)) {
      $faculty[] = $row;
    }

    print json_encode($faculty);
  }

?>