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
    <a href="?p=rprt" class="list-group-item">Reports</a>
    <a href="?p=inbx" class="list-group-item">
      Inbox<span id="menu-inbox-badge" class="badge pull-right"></span>
    </a>
    <a href="?p=sett&t=acct" class="list-group-item">Settings</a>
  </div>

<?php
  }
?>

<script>

  function init() {
    getInboxAmount();
  }

  function getInboxAmount() {
    $.ajax({
      type     : 'POST',
      url      : 'php/inboxmanager.php',
      dataType : 'json',
      data     : { 
        action : 'amount'
      },
      cache    : false,
      success  : function( result ) {
        $("#menu-inbox-badge").html(result);
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  init();

</script>