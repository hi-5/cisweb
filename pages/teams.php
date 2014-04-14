<!--
  - This page is included from settings.php. It
  - lists teams by year and can be used to delete,
  - add or update teams. A new sporting year can
  - be created from here as well.
  -
  - File: teams.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<?php
  loggedAdmin();
?>

<br />

<!-- new row -->
<div class="row">
  <div class="col-md-3">
   <div class="form-group">
      <select id="year-select" class="form-control">
        <!-- populates from populateYears() -->
      </select>
    </div>
  </div>
  <div class="col-md-9">
   <div class="form-group">
      <button id="create-year-button" type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;Create New Year</button>
    </div>
  </div>
</div>

<table id="table" class="table table-condensed">
  <thead>
    <tr>
      <th>ID</th>
      <th>Team Name</th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody id="table-body">
  </tbody>
</table>
<button id="add-team-button" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Team</button>

<!-- add team modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="modal-label" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
        <div id="school-name-container" class="form-group">
          <label>Team Name</label>
          <input id="team-name" type="input" class="form-control">
        </div>

      <div class="modal-footer">
        <button id="modal-close-button" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="modal-button" type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
      </div>
    </div>
  </div>
</div>

<script>

  var teamList = [],
      confirm = false;

  /**
   * entry point. called at bottom.
   */
  function init() {
    $("#modal-button").click(createTeam);
    $("#create-year-button").click(createYear);
    $("#year-select").change(getTeams);
    $("#team-table").hide();
    $("#add-team-button").hide();
    cislib.managerRequest("teams", "getYearList", undefined, populateYearList);
  }

  /**
   * populate the year list select box
   * with available years from database
   * @param result array of years
   */
  function populateYearList(result) {
    var selectBox = $("#year-select");
    for (var i = 0; i < result.length; i++)
      selectBox.append("<option>" + result[i] + "-" + (parseInt(result[i]) + 1) + "</option>");
    getTeams();
  }

  /**
   * request list of teams for the
   * selected year.
   */
  function getTeams() {
    var year = $("#year-select").val().substr(0, 4);
    cislib.managerRequest("teams", "getTeamsByYear", year, redrawTable);
  }

  /**
   * callback for managerRequest() in getTeams().
   * displays teams and adds buttons and event
   * listeners to modify teams
   * @param result array of teams from database
   */
  function redrawTable(result) {
    if (result.length == 0) 
      return;

    // store results locally
    teamList = result;

    // build table
    var tableString = "";
    for (var i = 0; i < result.length; i++) {
      tableString += "<tr>";
      tableString += "<td>" + result[i]["t_id"] + "</td>";
      tableString += "<td>" + result[i]["t_name"]  + "</td>";
      tableString += "<td><button id='delete-button-" + i + "'type='button' class='btn btn-danger btn-xs'>delete</button></td>";
      tableString += "</tr>";
    }
    $("#table-body").html(tableString);
    $("#table").show(); 
    $("#add-team-button").show();

    // add event listeners
    for (var i = 0; i < result.length; i++)
      $("#delete-button-" + i).click(deleteTeam);
  }

  // == button event listeners ==

  /**
   * callback for create year button click.
   * confirms and then adds a new year to database
   * based off previous years team list
   */
  function createYear() {
    var year = $("option")[0].innerHTML.substr(0, 4);
    if (confirm) {
      $("#create-year-button").hide();
      cislib.managerRequest("teams", "createNewYear", year, function(result) {
        window.location.href = window.location.href;
      });
    } else {
      confirm = true;
      $("#create-year-button").html(" Creating year " + (parseInt(year) + 1) + "-" + (parseInt(year) + 2) + ". Confirm?");
    }
  }

  /**
   * callback for create team button click.
   * adds a new team to the currently selected
   * year.
   */
  function createTeam() {
    var teamObject = {
      year: $("#year-select").val().substr(0, 4),
      name: $("#team-name").val()
    };
    cislib.managerRequest("teams", "createNewTeam", teamObject, function(result) {
      window.location.href = window.location.href;
    });
  }

  /**
   * callback for a delete team button click.
   * deletes the related team
   * @param event the click event
   */
  function deleteTeam(event) {
    if (event.currentTarget.innerHTML == "delete") {
      event.currentTarget.innerHTML = "confirm";
    } else {
      var index = event.currentTarget.id.substr(14),
          teamObject = {
            year: $("#year-select").val().substr(0, 4),
            id: teamList[index]["t_id"]
          };
      cislib.managerRequest("teams", "deleteTeam", teamObject, function(result) {
        window.location.href = window.location.href;
      });
    }
  }

  init();

</script>