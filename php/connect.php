<?php

/*
  - This file creates the sql variable that is used by all
  - database interaction scripts.
  -
  - File: connect.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/

  // create connection
  $sql = new mysqli("localhost", "mike", "onetwo", "cis");

  // check connection
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
?>