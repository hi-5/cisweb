<?PHP
  session_start();
  if ( !isset($_SESSION['loggedIn']) ) {
    $_SESSION['loggedIn'] = false;
  }
?>

<html>
  <head>
    <title>UofL Athlete Portal</title>
    <!-- style -->
    <link href="css/main.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- bootstrap framework -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" />
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  </head>

  <body>

    <?php
      include 'pages/header.php';
      include 'pages/body.php';
    ?>

  </body>
</html>