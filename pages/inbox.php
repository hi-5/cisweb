<!--
  - This page is included from body.php. Admins
  - can see the pending registrations and
  - choose to view them.
  -
  - File: inbox.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<?php
  include "./php/cislib.php";
  loggedAdmin();
?>

<div id="inbox-notice"></div>
<div class="panel panel-default">
  <div class="panel-heading">Inbox</div>
  <div id="inbox-body" class="panel-body">
    <table id="inbox-table" class="table table-condensed">
      <thead>
        <tr>
          <th>Student #</th>
          <th>Athlete Name</th>
          <th>Most Recent</th>
          <th>&nbsp</th>
        </tr>
      </thead>
      <tbody id="inbox-table-body">
      </tbody>
    </table>
  </div>
</div>

<script>

  /**
   * entry point. called from the bottom.
   */
  function init() {
    displayNotice();
    $("#reg-team-table").css("display", "none");  
    cislib.managerRequest("inbox", "retrieve", undefined, redrawTable);
  }

  /**
   * displays a notice if the URL
   * contains an 'r' flag
   */
  function displayNotice() {
    var r = cislib.getURLParameter("r");
    if (r) {
      switch(r) {
        case "app":
          $("#inbox-notice").html("<div class='alert alert-success'>Athlete form was successfully approved.</div>");
          break;
        case "appf":
          $("#inbox-notice").html("<div class='alert alert-danger'>Athlete form failed to approve.</div>");
          break;
        case "del":
          $("#inbox-notice").html("<div class='alert alert-success'>Athlete form was successfully deleted.</div>");
          break;
        case "delf":
          $("#inbox-notice").html("<div class='alert alert-danger'>Athlete form failed to delete.</div>");
          break;
      }
    }
  }

  /**
   * callback for managerRequest() in init().
   * displays pending registrations
   * @param event the click event
   */
  function redrawTable(result) {
    if (result.length == 0) {
      $("#inbox-body").html("There is nothing waiting in the inbox...");
    } else {
      var tableString = "";
      for (var i = 0; i < result.length; i++) {
        tableString += "<tr>";
        tableString += "<td>" + result[i]["id"] + "</td>";
        tableString += "<td>" + result[i]["last"] + ", " + result[i]["first"] + "</td>";
        tableString += "<td>" + result[i]["team"] + "</td>";
        tableString += "<td><a href='?p=form&t=app&i=" + result[i]["id"] + "'><button type='button' class='btn btn-xs btn-primary'>view</button></a></td></tr>";
      }
      $("#inbox-table-body").html(tableString);
    }
    
  }

  init();

</script>