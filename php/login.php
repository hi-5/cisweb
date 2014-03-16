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