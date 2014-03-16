<?php
  // create connection
  $sql = new mysqli("localhost", "testing2", "nwLGETTsWWDALwpY", "cis");

  // check connection
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
?>