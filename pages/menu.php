<!--
  - This page is included from body.php. It
  - displays the option to register to everyone
  - who has logged in. More options become
  - available if a user is faculty or admin status.
  -
  - File: menu.php
  - Author: Chris Wright/Mike Paulson
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<h3>Athletes</h3>
<div class="list-group">
  <a href="?p=form&t=reg" class="list-group-item">Register</a>
</div>

<?php
  if ($_SESSION['isFaculty']) {
?>

  <h3>Faculty</h3>
  <div class="list-group">
    <a href="?p=srch" class="list-group-item">Search</a>
    <a href="?p=rprt" class="list-group-item">Reports</a>

    <?php
      if ($_SESSION['isAdmin']) {
    ?>

      <a href="?p=team" class="list-group-item">Team</a>
      <a href="?p=inbx" class="list-group-item">
        Inbox<span id="menu-inbox-badge" class="badge pull-right"></span>
      </a>
      <a href="?p=sett" class="list-group-item">Settings</a>

    <?php
      }
    ?>

  </div>

  <script>

  function init() {
    cislib.managerRequest("inbox", "getAmount", undefined, updateBadge)
  }

  function updateBadge(result) {
    $("#menu-inbox-badge").html(result);
  }

  init();

  </script>

<?php
  }
?>