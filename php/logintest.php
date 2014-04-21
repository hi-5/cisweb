<!--
  - This file is used to create a session.
  - Once passed an ID num it will check it against
  - the database for admin status.

  - File: logintest.php
  - Author: Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
-->

<?php
  include "connect.php";
  include "cislib.php";
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