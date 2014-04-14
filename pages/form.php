<!--
  - This page is included from body.php. It includes
  - either the initial consent form when registering
  - or the athlete information form when registering,
  - approving, deleting, or updating athlete information.
  -
  - File: form.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

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
    case "ver": // verification
    case "upd": // athlete update
    case "app": // athlete approval
      include 'pages/formp2.php';
      break;
  }

?>