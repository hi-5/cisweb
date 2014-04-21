<?PHP
  session_start();
  if ( !isset($_SESSION['loggedIn']) ) {
    $_SESSION['loggedIn'] = false;
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>UofL Athlete Portal</title>
    <!-- style -->
    <link href="css/main.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- bootstrap framework -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.min.js"></script>
    <!-- bootstrap datepicker -->
    <link href="css/datepicker.css" rel="stylesheet">
    <script src="js/datepicker.js"></script>
    <!-- cis library -->
    <script src="js/cislib.js"></script>
  </head>

  <body>

    <?php
      include 'pages/header.php';
      include 'pages/body.php';
    ?>

  </body>
</html>