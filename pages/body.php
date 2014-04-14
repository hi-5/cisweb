<!--
  - This page is included from index.php. It
  - acts as the hub for including all content
  - pages. This page is only accessible if
  - $_SESSION["loggedIn"] = true;
  -
  - File: body.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<br /><br /><br /><br />

<div id="wrapper">

  <?php
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
              case 'team' : $file = 'team.php'; break;
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