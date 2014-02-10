<!-- get setting type and tab class information -->
<?php
  if ( isset($_GET['t']) )
    $type = $_GET['t'];
  else
    $type = 'acct';

  $acctAct = ( $type == 'acct' ) ? 'class="active"' : '';
  $profAct = ( $type == 'prof' ) ? 'class="active"' : '';
  $faclAct = ( $type == 'facl' ) ? 'class="active"' : '';
  $teamAct = ( $type == 'team' ) ? 'class="active"' : '';
?>

<!-- set up the settings navigation tabs -->
<ul class="nav nav-tabs">
  <li <?php echo $acctAct; ?>><a href="?p=sett&t=acct">Accounts</a></li>
  <li <?php echo $profAct; ?>><a href="?p=sett&t=prof">Profiles</a></li>
  <li <?php echo $faclAct; ?>><a href="?p=sett&t=facl">Faculty</a></li>
  <li <?php echo $teamAct; ?>><a href="?p=sett&t=team">Teams</a></li>
</ul>

<!-- insert settings content -->
<?php
  switch ( $type ) {
    case 'acct' : $file = 'accounts.php'; break;
    case 'prof' : $file = 'profiles.php'; break;
    case 'facl' : $file = 'faculty.php';  break;
    case 'team' : $file = 'teams.php';    break;
  }
  include 'pages/' . $file;
?>