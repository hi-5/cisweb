<!--
  - This page is included from body.php. It
  - displays a tabbed navigation for
  - settings. Includes either faculty or
  - team settings information.
  -
  - File: settings.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<!-- get setting type and tab class information -->
<?php

  include "./php/cislib.php";
  loggedAdmin();

  if ( isset($_GET['t']) )
    $type = $_GET['t'];
  else
    $type = 'facl';

  $facl = ( $type == 'facl' ) ? 'class="active"' : '';
  $team = ( $type == 'team' ) ? 'class="active"' : '';
?>

<div class="panel panel-default">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">
    <!-- navigation tabs -->
    <ul class="nav nav-tabs">
      <li <?php echo $facl; ?>><a href="?p=sett&t=facl">Faculty</a></li>
      <li <?php echo $team; ?>><a href="?p=sett&t=team">Teams</a></li>
    </ul>

    <!-- include selected settings page -->
    <?php
      switch ( $type ) {
        case 'facl' : $file = 'faculty.php';  break;
        case 'team' : $file = 'teams.php';    break;
      }
      include 'pages/' . $file;
    ?>
  </div>
</div>

