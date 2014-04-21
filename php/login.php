<!--
  - This is a test login page used during development.
  - It creates a session based on the type passed to it.
  -
  - File: login.php
  - Author: Chris Wright
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
-->

<?php

  session_start();

  $type = $_GET['t'];
  switch ($type) {

    case "athlete":
      $_SESSION['studentId'] = "123456789";
      $_SESSION['isAdmin'] = false;
      $_SESSION['isFaculty'] = false;
      break;

    case "coach":
      $_SESSION['studentId'] = "486728502";
      $_SESSION['isAdmin'] = false;
      $_SESSION['isFaculty'] = true;
      break;

    case "admin":
      $_SESSION['studentId'] = "960275391";
      $_SESSION['isAdmin'] = true;
      $_SESSION['isFaculty'] = true;
      break;
  }

  $_SESSION['loggedIn'] = true;
  header( 'Location: ../index.php' );
?>