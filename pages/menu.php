<h3>Athletes</h3>
<div class="list-group">
  <a href="?p=form&t=reg" class="list-group-item">Form</a>
</div>

<?php
  if ($_SESSION['isFaculty']) {
?>

  <h3>Faculty</h3>
  <div class="list-group">
    <a href="?p=srch" class="list-group-item">Search</a>
    <a href="?p=inbx" class="list-group-item">
      Inbox<span id="menu-inbox-badge" class="badge pull-right"></span>
    </a>
    <a href="?p=rprt" class="list-group-item">Reports</a>
    <a href="?p=sett" class="list-group-item">Settings</a>
  </div>

<?php
  }
?>

<script>

  function init() {
    cislib.managerRequest("inbox", "getAmount", undefined, updateBadge)
  }

  function updateBadge(result) {
    $("#menu-inbox-badge").html(result);
  }

  init();

</script>