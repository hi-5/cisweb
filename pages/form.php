<?php

  // register, verify, or inbox
  $formType = isset($_GET['t']) ? $_GET['t'] : "reg";

  switch($formType) {
    // registration
    case "reg":
      $stepNumber = isset($_GET['s']) ? $_GET['s'] : 1;
      include 'pages/formp' . $stepNumber . '.php';
      break;

    // verification/admin
    case "ver":
    case "box":
      include 'pages/formp2.php';
      break;
  }

?>