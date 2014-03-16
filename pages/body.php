<br /><br /><br /><br />

<div id="wrapper">

  <?php

    // DEBUG - next 4 lines
    //$_SESSION['studentId'] = "123456789";
    //$_SESSION['loggedIn'] = true;
    //$_SESSION['isAthlete'] = true;
    //$_SESSION['isFaculty'] = true;

    if ($_SESSION['loggedIn']) {
  ?>

    <div class="row">

      <!-- user menu -->
      <div class="col-md-2">

        <?php
          include 'pages/menu.php';
        ?>

      </div>

      <!-- page content -->
      <div class="col-md-10">

        <?php
          if (isset($_GET['p'])) {
            switch ($_GET['p']) {
              case 'form' : $file = 'form.php'; break;
              case 'inbx' : $file = 'inbox.php'; break; 
              case 'srch' : $file = 'search.php'; break;
              case 'rprt' : $file = 'reports.php'; break;     
              case 'sett' : $file = 'settings.php'; break;  
            }
          } else {
            $file = 'home.php';
          }
          include 'pages/' . $file;
        ?>

      </div>
    </div>

  <?php
    } else {
      include 'pages/welcome.php';
    }
  ?>
  
</div>