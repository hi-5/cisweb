<!--
  - This page is included from body.php.
  - It is the first page displayed after
  - logging in and after submitting a
  - registration form from formp2.php.
  -
  - File: home.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<?php
  if (isset($_GET["n"])) {
    switch ($_GET["n"]) {
      case "regs":
        echo "<div class='alert alert-success'>Your registration form was successfully submitted. Thank you.</div>";
        break;
      case "regf":
        echo "<div class='alert alert-danger'>There was a problem with your registration. Please contact an administrator for more information.</div>";
        break;
    }
  }
?>

Welcome to the CIS Athlete Registrar Portal.<br /><br />
To get started, select an option from the left-side menu.
