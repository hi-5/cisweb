<?php

  session_start();
  if ($_SESSION['isAdmin'] != true)
    exit();

  include "connect.php";

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

  function delete() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']);

    $query = "DELETE FROM faculty WHERE f_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result; 
  }

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