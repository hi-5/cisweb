<?php
  include "connect.php";
  include "cislib.php";
  
  global $sql;

  session_start();


  $id = $_POST['num'];

  if (isAdmin($id, $sql) == 1) {
    $_SESSION['isAdmin'] = true; 
    $_SESSION['isFaculty'] = true; 
  } else {
    $_SESSION['isAdmin'] = false;
    $_SESSION['isFaculty'] = false;
  }

  $_SESSION['studentId'] = $id;

  $_SESSION['loggedIn'] = true;

  header( 'Location: ../index.php' );
?>