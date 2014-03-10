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

  function init() {
    $("#search-mode").change(searchModeChange);
    $("#search-button").click(searchButtonClick);
  }

  function searchModeChange( event ) {
    var mode = event.target.value,
        placeholder = (mode == "Athlete") ? "by student #, last name or first name..." : "by year...";
    $("#search-text").attr("placeholder", placeholder);
  }

  function searchButtonClick() {
    var action = ($("#search-mode").val() == "Athlete") ? "getAthlete" : "getTeam",
        searchText = $("#search-text").val();
    cislib.managerRequest("search", action, searchText, redrawContainer);
  }

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
        tableString += "<thead><tr><td>Student #</td><td>Last Name</td><td>First Name</td><td>Current Team</td></tr></thead><tbody>";
        break;
      case "teams":
        tableString += "<thead><tr><td>Year</td><td>Team Name</td><td>Head Coach</td><td>Asst. Coach</td></tr></thead><tbody>";
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
    //addEventListeners();
  }

  function addEventListeners() {
    console.log(resultList.length);
    for (var i = 0; i < resultList.length; i++) {
      $("#search-athlete-id-" + i).css("cursor", "pointer");
      $("#search-athlete-id-" + i).css("text-decoration", "underline");
    }
  }

  init();

</script>