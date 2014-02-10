<?php

  if ( isset($_GET['s']) )
    $stepNumber = $_GET['s'];
  else
    $stepNumber = 1;

  include 'pages/registerp' . $stepNumber . '.php';

?>