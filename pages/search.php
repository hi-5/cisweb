<!--
  - This page is included from body.php. It
  - is used to search the database for athlete
  - and team records.
  -
  - File: search.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

<?php
  include "./php/cislib.php";
  loggedAdmin();
?>

<!-- new row -->
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <select id="search-mode" class="form-control">
        <option>Athlete</option>
        <option>Team</option>
      </select>
    </div>
  </div>
  <div class="col-md-10">
   <div class="form-group">
      <div class="input-group">
        <input id="search-text" type="text" class="form-control" placeholder="by student #, last name or first name...">
        <span class="input-group-btn">
          <button id="search-button" class="btn btn-default" type="button">Search</button>
        </span>
    </div>
    </div>
  </div>
</div>

<!-- new row -->
<div class="row">
  <div class="col-md-12">
    <table class="table" id="search-results">
      <!-- populates with search results -->
    </div>
  </div>
</div>

<script>

  var resultType = "",
      resultList = [];

  /**
   * entry point. called from the bottom.
   */
  function init() {
    $("#search-mode").change(searchModeChange);
    $("#search-button").click(searchButtonClick);
  }

  /**
   * callback for search mode select box change
   * event. sets the placeholder text for the
   * search box.
   * @param event the click event
   */
  function searchModeChange( event ) {
    var mode = event.target.value,
        placeholder = (mode == "Athlete") ? "by student #, last name or first name..." : "by year...";
    $("#search-text").attr("placeholder", placeholder);
  }

  /**
   * makes a search request for either
   * and athlete or a team.
   */
  function searchButtonClick() {
    var action = ($("#search-mode").val() == "Athlete") ? "getAthlete" : "getTeam",
        searchText = $("#search-text").val();
    cislib.managerRequest("search", action, searchText, redrawContainer);
  }

  /**
   * callback managerRequest() in searchButtonClick().
   * redraws the search table based on search results.
   * @param result array results of the database search
   */
  function redrawContainer(result) {
    resultType = result[0];
    var tableString = "";

    // notify the user if no results
    if (result.length == 1) {
      $("#search-results").html("There were no results for that search...");
      return;
    }

    // create table headers
    switch (resultType) {
      case "athletes":
        tableString += "<thead><tr><th>Student #</th><th>Last Name</th><th>First Name</th><th>Current Team</th></tr></thead><tbody>";
        break;
      case "teams":
        tableString += "<thead><tr><th>Year</th><th>Team Name</th><th>Head Coach</th><th>Asst. Coach</th></tr></thead><tbody>";
        break;
    }

    // create table rows from data
    for (var i = 1; i < result.length; i++) {
      resultList.push(result[i]); // store the results locally
      switch (resultType) {
        case "athletes":
          tableString += "<tr><td><a href='?p=form&t=upd&i=" + result[i]["a_studentId"] + "'>" + result[i]["a_studentId"] + "</a></td><td>" + result[i]["a_lastName"] + "</td><td>" + result[i]["a_firstName"] + "</td><td>No Current Team</td></tr>";
          break;
        case "teams":
          tableString += "<tr><td>" + result[i]["t_year"] + "</td><td>" + result[i]["t_name"] + "</td><td>" + "Coach Name Here" + "</td><td>" + "Coach Name Here" + "</td></tr>";
          break;
      }
    }
    tableString += "</tbody>";
    $("#search-results").html(tableString);
  }

  init();

</script>