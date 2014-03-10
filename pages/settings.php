<!-- get setting type and tab class information -->
<?php
  if ( isset($_GET['t']) )
    $type = $_GET['t'];
  else
    $type = 'gnrl';

  $gnrl = ( $type == 'gnrl' ) ? 'class="active"' : '';
  $facl = ( $type == 'facl' ) ? 'class="active"' : '';
  $team = ( $type == 'team' ) ? 'class="active"' : '';
?>

<div class="panel panel-default">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">
    <!-- navigation tabs -->
    <ul class="nav nav-tabs">
      <li <?php echo $gnrl; ?>><a href="?p=sett&t=gnrl">General</a></li>
      <li <?php echo $facl; ?>><a href="?p=sett&t=facl">Faculty</a></li>
      <li <?php echo $team; ?>><a href="?p=sett&t=team">Teams</a></li>
    </ul>

    <!-- include selected settings page -->
    <?php
      switch ( $type ) {
        case 'gnrl' : $file = 'general.php'; break;
        case 'facl' : $file = 'faculty.php';  break;
        case 'team' : $file = 'teams.php';    break;
      }
      include 'pages/' . $file;
    ?>
  </div>
</div>

