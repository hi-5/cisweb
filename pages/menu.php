<?php
  if ( $_SESSION['isStudent'] ) {
?>

  <h3>Athletes</h3>
  <div class="list-group">
    <a href="?p=regi" class="list-group-item active">Registration</a>
    <a href="?p=veri" class="list-group-item">Verification</a>
  </div>

<?php
  } else {
?>

  <h3>Faculty</h3>
  <div class="list-group">
    <a href="?p=srch" class="list-group-item">Search</a>
    <a href="?p=rprt" class="list-group-item">Reports</a>
    <a href="?p=reqs" class="list-group-item">
      Inbox<span class="badge pull-right">3</span>
    </a>
    <a href="?p=sett&t=acct" class="list-group-item">Settings</a>
  </div>

<?php
  }
?>