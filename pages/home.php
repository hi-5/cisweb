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

This is a mockup of the CIS Website and the default home page.<br />
Click 'Sign In' above to get started!
