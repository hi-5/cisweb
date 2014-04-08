
<?php

  include "./php/cislib.php";
  loggedStudent($_REQUEST['i']);

?>

<div id="header" class="row">
  <div class="col-md-2">
    <img src="images/letterhead.png" />
  </div>
  <div class="col-md-10">
    <h4>Student-Athlete Registration Form<br />Step 2 of 2</h4>
  </div>
</div>

<br />

<form role="form" method="post">

  <div class="panel panel-default">
    <div class="panel-heading">Athlete Information</div>
    <div class="panel-body">
      
      <!-- new row -->
      <div class="row">
        <div class="col-md-3">
         <div class="form-group">
            <label>Student #</label>
            <input id="student-number" type="input" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
            <label>Email</label>
            <input id="email" type="email" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
         <div class="form-group">
            <label>Canadian Resident</label>
            <select id="resident-select" class="form-control">
              <option>no</option>
              <option>yes</option>
            </select>
          </div>
        </div>
      </div>

      <!-- new row -->
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <label>First Name</label>
            <input id="first-name" type="input" class="form-control">
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label>Last Name</label>
            <input id="last-name" type="input" class="form-control">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Initial(s)</label>
            <input id="initials" type="input" class="form-control">
          </div>
        </div>
      </div>

      <!-- new row -->
      <div class="row">

        <div class="col-md-3">
          <div class="form-group">
            <label>Gender</label>
            <select id="gender" class="form-control">
              <option>Male</option>
              <option>Female</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Date of Birth</label>
            <input id="date-of-birth" type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Height</label>
            <select id="height" class="form-control">
              <!-- heights will be populated here from initializeForm() -->
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Weight (lbs.)</label>
            <input id="weight" type="input" class="form-control" placeholder="ex. 160">
          </div>
        </div>
      </div>

      <!-- new row -->
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>High School</label>
            <input id="high-school" type="input" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Year of Graduation</label>
            <input id="year-of-graduation" type="input" class="form-control" placeholder="YYYY">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Hometown</label>
            <input id="hometown" type="input" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>University Program</label>
            <input id="program" type="input" class="form-control">
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">Current Address</div>
    <div class="panel-body">

      <!-- new row -->
      <div class="row">
        <div class="col-md-6">
         <div class="form-group">
            <label>Street</label>
            <input id="current-street" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>City</label>
            <input id="current-city" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Province</label>
            <input id="current-province" type="input" class="form-control">
          </div>
        </div>
      </div>

      <!-- new row -->
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Phone</label>
            <input id="current-phone" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Postal Code</label>
            <input id="current-postal" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Country</label>
            <input id="current-country" type="input" class="form-control">
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      Permanent Address
      <button id="copy-address-button" type="button" class="btn btn-primary btn-xs pull-right">Same as Current Address</button>
    </div>
    <div class="panel-body">

      <!-- new row -->
      <div class="row">
        <div class="col-md-6">
         <div class="form-group">
            <label>Street</label>
            <input id="permanent-street" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>City</label>
            <input id="permanent-city" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Province</label>
            <input id="permanent-province" type="input" class="form-control">
          </div>
        </div>
      </div>

      <!-- new row -->
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Phone</label>
            <input id="permanent-phone" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Postal Code</label>
            <input id="permanent-postal" type="input" class="form-control">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>Country</label>
            <input id="permanent-country" type="input" class="form-control">
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      Athlete History
      <button id="non-uofl-team-button" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modal">Add Non-UofL Team</button>
      <button id="uofl-team-button" type="button" class="btn btn-primary btn-xs pull-right right-space" data-toggle="modal" data-target="#modal">Add UofL Team</button>
    </div>
    <div class="panel-body">

      <!-- new row -->
      <div class="row">
        <table id="team-table" class="table">
          <thead>
            <tr>
              <th>Year</th>
              <th>Institute</th>
              <th>Team</th>
              <th>Position</th>
              <th>Jersey</th>
              <th>Charged</th>
              <th> </th>
              <th> </th>
            </tr>
          </thead>
          <tbody id="team-table-body"></tbody>
        </table>
      </div>

      <!-- suspensions text area 
      <textarea id="suspensions" class="form-control" rows="3" placeholder="Please indicate if you are presently under suspension from any sport organization or league."></textarea>
      -->
    </div>
  </div>

  <div id="disclaimer" class="well">
    * The information collected in this form is used and disclosed by Canadian Interuniversity Sport("CIS") in accordance with the terms of CIS' Student Athlete Acknowledgement Form and CIS' Personal Information Protection Policy.<br />
    For further information about CIS' collection, use and disclosure of personal information, see our Personal Information Protection Policy at <a href="http://www.cis-sic.ca">www.cis-sic.ca</a>.
  </div>

  <!-- new row -->
  <div class='row'>
    <div class="col-md-8"></div>
    <div id="buttons-1" class="col-md-2">
      <!-- populates with buttons depending on form type (register, verify, approve/delete) -->
    </div>
    <div id="buttons-2" class="col-md-2">
      <!-- populates with buttons depending on form type (register, verify, approve/delete) -->
    </div>
  </div>

</form>

<br /><br />

<!-- add team modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="modal-label" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
        <!-- new row -->
        <div class="row">
          <div class="col-md-6">
            <div id="team-list-container" class="form-group">
              <label>Team</label>
              <select id="team-list" class="form-control">
                <!-- teams will be populated here from getTeams() -->
              </select>
            </div>
            <div id="team-name-container" class="form-group">
              <label>Team Name</label>
              <input id="team-name" type="input" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div id="school-name-container" class="form-group">
              <label>School Name</label>
              <input id="school-name" type="input" class="form-control">
            </div>
          </div>
        </div>

        <!-- new row -->
        <div class="row">
          <div class="col-md-3">
           <div class="form-group">
              <label>Position</label>
              <input id="team-position" type="input" class="form-control">
            </div>
          </div>

          <div class="col-md-3">
           <div class="form-group">
              <label>Year</label>
              <select id="team-year" class="form-control">
                <!-- years will be populated here from initializeForm() -->
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Jersey #</label>
              <input id="team-jersey" type="input" class="form-control">
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>Year Charged</label>
              <select id="team-charged" class="form-control">
                <option>yes</option>
                <option>no</option>
              </select>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button id="modal-close-button" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="modal-button" type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
      </div>
    </div>
  </div>
</div>

<script>

  var teamHistory = new Array(), // athletes team history
      teamList = new Array(), // uofl team list
      numOfEventListeners = 0,
      currentId = "000000000",
      formType = "reg";
      
  function init() {
    // get target studentId and form type from the URL
    currentId = cislib.getURLParameter("i");
    formType = cislib.getURLParameter("t");
    initializeForm();
  }

  function initializeForm() {
    // populate university team list on page and add appropriate buttons for form type
    cislib.managerRequest("teams", "getDistinctTeamList", undefined, function(result) {
      var htmlString = "";
      for (var i = 0; i < result.length; i++) {
        teamList.push({
          id   : result[i].t_id,
          name : result[i].t_name
        });
        htmlString += "<option>" + result[i].t_name + "</option>";
      }
      $("#team-list").html(htmlString);
    });

    // initialize date picker
    $("#date-of-birth").datepicker({
      startView: "decade"
    });

    // initialize address copy button
    $("#copy-address-button").click(function(event) {
      $("#permanent-street").val($("#current-street").val());
      $("#permanent-city").val($("#current-city").val());
      $("#permanent-province").val($("#current-province").val());
      $("#permanent-phone").val($("#current-phone").val());
      $("#permanent-postal").val($("#current-postal").val());
      $("#permanent-country").val($("#current-country").val());
    });

    // disable ability to change studentId
    $("#student-number").attr("disabled", "disabled");

    // buttons to add teams
    $("#non-uofl-team-button").click(addNonUofLTeamClick);
    $("#uofl-team-button").click(addUofLTeamClick);
    $("#modal-button").click(addUpdateTeamClick);

    // hide team table
    $("#team-table").css("display", "none");

    // populate height select box
    var feet = 8,
        inches = 0,
        heightBox = $("#height");
    for (var i = 0; i < 49; i++) {
      heightBox.append("<option>" + feet + "'" + inches +  "\"</option>");
      inches--;
      if (inches < 0) {
        feet--;
        inches = 11;
      }
    }

    // populate the year select box
    for (var i = new Date().getFullYear() + 1; i > 1970; i--)
      $("#team-year").append("<option>" + i + "-" + (i + 1) + "</option>");

    // add buttons and event listeners
    // also request known information if available
    switch (formType) {

      // registration form
      case "reg":
        $("#student-number").val(currentId);
        $("#buttons-2").html("<button id='register-button' type='button' class='btn btn-lg btn-primary'>Register</button>");
        $("#register-button").click(registerButtonClick);
        break;

      // verification form
      case "ver":
        $("#header").css("display", "none");
        $("#buttons-2").html("<button id='verify-button' type='button' class='btn btn-lg btn-primary'>Verify</button>");
        $("#verify-button").click(verifyButtonClick);
        cislib.managerRequest("form", "getAthlete", {id:currentId, queue:"no"}, populateKnownFields);
        break;

      // update form
      case "upd":
        $("#header").css("display", "none");
        $("#disclaimer").css("display", "none");
        $("#buttons-2").html("<button id='update-button' type='button' class='btn btn-lg btn-primary'>Update</button>");
        $("#update-button").click(updateButtonClick);
        cislib.managerRequest("form", "getAthlete", {id:currentId, queue:"no"}, populateKnownFields);
        break;

      // approval form
      case "app":
        $("#header").css("display", "none");
        $("#disclaimer").css("display", "none");
        $("#buttons-1").html("<button id='approve-button' type='button' class='btn btn-lg btn-warning'>Approve</button>");
        $("#buttons-2").html("<button id='delete-button' type='button' class='btn btn-lg btn-danger'>Delete</button>");
        $("#approve-button").click(approveButtonClick);
        $("#delete-button").click(deleteButtonClick);
        cislib.managerRequest("form", "getAthlete", {id:currentId, queue:"yes"}, populateKnownFields);
        break;
    }
  }

  function populateKnownFields(result) {
    var infoPrefix = result[0],
        info = result[1];
    $("#student-number").val(info[infoPrefix + "studentId"]);
    $("#resident-select").prop("selectedIndex", info[infoPrefix + "resident"]);
    $("#email").val(info[infoPrefix + "email"]);
    $("#last-name").val(info[infoPrefix + "lastName"]);
    $("#first-name").val(info[infoPrefix + "firstName"]);
    $("#initials").val(info[infoPrefix + "initials"]);
    $("#gender").val(info[infoPrefix + "gender"]);
    $("#date-of-birth").val(info[infoPrefix + "dob"]);
    $("#height").val(info[infoPrefix + "height"]);
    $("#weight").val(info[infoPrefix + "weight"]);
    $("#hometown").val(info[infoPrefix + "hometown"]);
    $("#high-school").val(info[infoPrefix + "highSchool"]);
    $("#year-of-graduation").val(info[infoPrefix + "gradYear"]);
    $("#program").val(info[infoPrefix + "program"]);

    $("#current-street").val(info[infoPrefix + "cStreet"]);
    $("#current-city").val(info[infoPrefix + "cCity"]);
    $("#current-province").val(info[infoPrefix + "cProvince"]);
    $("#current-postal").val(info[infoPrefix + "cPostalCode"]);
    $("#current-country").val(info[infoPrefix + "cCountry"]);
    $("#current-phone").val(info[infoPrefix + "cPhone"]);

    $("#permanent-street").val(info[infoPrefix + "pStreet"]);
    $("#permanent-city").val(info[infoPrefix + "pCity"]);
    $("#permanent-province").val(info[infoPrefix + "pProvince"]);
    $("#permanent-postal").val(info[infoPrefix + "pPostalCode"]);
    $("#permanent-country").val(info[infoPrefix + "pCountry"]);
    $("#permanent-phone").val(info[infoPrefix + "pPhone"]);

    // add teams to js array
    var histPrefix = result[2];
    for (var i = 3; i < result.length; i++) {
      addTeam(
        result[i][histPrefix + "year"],
        result[i][histPrefix + "institute"],
        result[i][histPrefix + "teamId"],
        result[i][histPrefix + "teamName"],
        result[i][histPrefix + "position"],
        result[i][histPrefix + "jerseyNumber"],
        result[i][histPrefix + "charged"]
      );
    }
  }

  // == team history ==

  function redrawTeamTable() {
    for (var i = 0; i < numOfEventListeners; i++) {
      $("#team-edit-" + i).unbind();
      $("#team-remove-" + i).unbind();
    }
    numOfEventListeners = 0;

    // create table
    var tableString = "";
    for (var j = 0; j < teamHistory.length; j++) {
      tableString += "<tr>";
      tableString += "<td>" + teamHistory[j].year + "-" + (parseInt(teamHistory[j].year) + 1) + "</td>";
      tableString += "<td>" + teamHistory[j].institute + "</td>";
      tableString += "<td>" + teamHistory[j].teamName + "</td>";
      tableString += "<td>" + teamHistory[j].position + "</td>";
      tableString += "<td>" + teamHistory[j].jersey + "</td>";
      tableString += "<td>" + teamHistory[j].charged + "</td>";
      tableString += "<td><button id='team-edit-" + j + "' type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#modal'>edit</button></td>";
      tableString += "<td><button id='team-remove-" + j + "' type='button' class='btn btn-xs btn-danger'>remove</button></td>";
      tableString += "</tr>";
      numOfEventListeners++;
    }
    $("#team-table-body").html(tableString);
    $("#team-table").css("display", "block");

    // add event listeners
    for (var k = 0; k < numOfEventListeners; k++) {
      $("#team-edit-" + k).click(editTeamClick);
      $("#team-remove-" + k).click(removeTeamClick);
    }
  }

  function addTeam(year, institute, teamId, teamName, position, jersey, charged) {

    // format charged
    if (charged == "1")
      charged = "yes";
    else if (charged == "0")
      charged = "no";

    // add team to memory and redraw the table
    teamHistory.push({
      year      : year,
      institute : institute,
      teamId    : teamId,
      teamName  : teamName,
      position  : position,
      jersey    : jersey,
      charged   : charged
    });
    redrawTeamTable();
  }

  function removeTeam(index) {
    teamHistory.splice(index, 1);
    if (teamHistory.length == 0)
      $("#team-table").hide();
    redrawTeamTable();
  }

  function getSelectedTeamId() {
    var selectedTeam = $("#team-list").val();
    for (var i = 0; i < teamList.length; i++)
      if (teamList[i].name == selectedTeam)
        return teamList[i].id;
    return 0;
  }

  // == team history event listeners ==

  function addUofLTeamClick(event) {
    $("#modal-label").html("Add UofL Team");
    $("#modal-button").html("Add");
    $("#team-list-container").show();
    $("#team-name-container").hide();
    $("#school-name-container").hide();
    $("#school-name").val("University of Lethbridge");
    $("#team-position").val("");
    $("#team-jersey").val("");
  }

  function addNonUofLTeamClick(event) {
    $("#modal-label").html("Add Non-UofL Team");
    $("#modal-button").html("Add");
    $("#team-list-container").hide();
    $("#team-name-container").show();
    $("#school-name-container").show();
    $("#school-name").val("");
    $("#team-name").val("");
    $("#team-position").val("");
    $("#team-jersey").val("");
  }

  function editTeamClick(event) {
    $("#modal-label").html("Edit Team History");
    $("#modal-button").html("Update");
    $("#team-list-container").hide();
    $("#team-name-container").show();
    $("#school-name-container").show();

    var index = event.target.id.substr(10);
    var team = teamHistory[index];
    $("#school-name").val(team.institute);
    $("#team-year").val(parseInt(team.year) + "-" + parseInt(Number(team.year) + 1));
    $("#team-name").val(team.teamName);
    $("#team-position").val(team.position);
    $("#team-jersey").val(team.jersey);
  }

  function removeTeamClick(event) {
    if (event.target.innerHTML == "remove") {
      event.target.innerHTML = "confirm";
    } else {
      $("#" + event.target.id).unbind();

      var index = event.target.id.substr(12);
      var teamObject = {
        queue     : (formType == "reg" || formType == "app") ? "yes" : "no",
        studentId : currentId,
        year      : teamHistory[index].year
      };
      cislib.managerRequest("form", "removeTeam", teamObject, function(result) {
        removeTeam(index);
      });
    }
  }

  // == modal event listeners ==

  function addUpdateTeamClick(event) {
    // !!! validate input
    var years = $("#team-year").val().split("-"),
        startYear = years[0],
        endYear = years[1],
        schoolName = $("#school-name").val(),
        position = $("#team-position").val(),
        jersey = $("#team-jersey").val(),
        charged = $("#team-charged").val();

    // get team name
    var teamName = "", 
        teamId = 0;
    if ($("#team-list-container").is(":visible")) {
      teamName = $("#team-list").val();
      teamId = getSelectedTeamId();
    } else {
      teamName = $("#team-name").val();
    }

    // send team to server
    var teamObject = {
      queue     : (formType == "reg" || formType == "app") ? "yes" : "no",
      studentId : currentId,
      year      : startYear,
      teamId    : teamId,
      teamName  : teamName,
      institute : schoolName,
      position  : position,
      jersey    : jersey,
      charged   : charged
    };
    cislib.managerRequest("form", "addTeam", teamObject, function(result) {
      addTeam(result['year'], result['institute'], result['teamId'], result['teamName'], result['position'], result['jersey'], result['charged']);
    });
  }

  // == form submit event listeners ==

  function registerButtonClick(event) {
    if (validateForm()) return;

    var athleteObject = getAthleteObject();
    cislib.managerRequest("form", "register", athleteObject, function(result) {
      if (result)
        window.location.href = "?n=regs";
      else
        window.location.href = "?n=regf";
    });
  }

  function verifyButtonClick(event) {

  }

  function updateButtonClick(event) {
    if (validateForm()) return;

    var athleteObject = getAthleteObject();
    cislib.managerRequest("form", "update", athleteObject, function(result) {
      if (result)
        window.location.href = "?p=srch&r=upds";
      else
        window.location.href = "?p=srch&r=updf";
    });
  }

  function approveButtonClick(event) {
    if (validateForm()) return;

    var athleteObject = getAthleteObject();
    cislib.managerRequest("form", "approve", athleteObject, function(result) {
      if (result)
        window.location.href = "?p=inbx&r=app";
      else
        window.location.href = "?p=inbx&r=appf";
    });
  }

  function deleteButtonClick(event) {
    if (event.target.innerHTML == "Delete") {
      event.target.innerHTML = "Confirm";
    } else {
      cislib.managerRequest("form", "delete", currentId, function(result) {
        if (result)
          window.location.href = "?p=inbx&r=del";
        else
          window.location.href = "?p=inbx&r=delf";
      });
    }
  }

  // == data functions ==

  function validateForm() {
    var email = $("#email").val(),
        lastName = $("#last-name").val(),
        firstName = $("#first-name").val(),
        dob = $("#date-of-birth").val(),
        weight = $("#weight").val(),
        hometown = $("#hometown").val(),
        highSchool = $("#high-school").val(),
        gradYear = $("#year-of-graduation").val(),
        program = $("#program").val(),

        cStreet = $("#current-street").val(),
        cCity = $("#current-city").val(),
        cProvince = $("#current-province").val(),
        cPostal = $("#current-postal").val(),
        cCountry = $("#current-country").val(),
        cPhone = $("#current-phone").val(),

        pStreet = $("#permanent-street").val(),
        pCity = $("#permanent-city").val(),
        pProvince = $("#permanent-province").val(),
        pPostal = $("#permanent-postal").val(),
        pCountry = $("#permanent-country").val(),
        pPhone = $("#permanent-phone").val();

    var foundError = false,
        element = undefined,
        error = "";
    if (email.trim() == "" || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
      foundError = true;
      element = $("#email");
      error = "Please enter a valid email address.";
    } else if (lastName.trim() == "") {
      foundError = true;
      element = $("#last-name");
      error = "Please enter your last name.";
    } else if (firstName.trim() == "") {
      foundError = true;
      element = $("#first-name");
      error = "Please enter your first name.";
    } else if (dob.trim() == "") {
      foundError = true;
      element = $("#date-of-birth");
      error = "Please enter your date of birth";
    } else if (weight.trim() == "") {
      foundError = true;
      element = $("#weight");
      error = "Please enter your weight.";
    } else if (hometown.trim() == "") {
      foundError = true;
      element = $("#hometown");
      error = "Please enter your hometown.";
    } else if (highSchool.trim() == "") {
      foundError = true;
      element = $("#high-school");
      error = "Please enter your high school.";
    } else if (gradYear.trim() == "") {
      foundError = true;
      element = $("#year-of-graduation");
      error = "Please enter your year of high school graduation.";
    } else if (program.trim() == "") {
      foundError = true;
      element = $("#program");
      error = "Please enter your university program.";
    } else if (cStreet.trim() == ""   || cCity.trim() == "" ||
               cProvince.trim() == "" || cPostal.trim() == "" ||
               cCountry.trim() == ""  || cPhone.trim() == "") {
      foundError = true;
      element = $("#current-street");
      error = "Please enter your full address.";
    } else if (pStreet.trim() == ""   || pCity.trim() == "" ||
               pProvince.trim() == "" || pPostal.trim() == "" ||
               pCountry.trim() == ""  || pPhone.trim() == "") {
      foundError = true;
      element = $("#permanent-street");
      error = "Please enter your full address.";
    }

    // scroll page to error and display it
    if (foundError) {
      $("html,body").animate({ scrollTop: element.offset().top - 100 }, "slow");
      element.tooltip({ 
        placement: "bottom",
        title: error 
      }).tooltip("show");
    }

    // return error result
    return foundError;
  }

  function getAthleteObject() {
    // store the information as an object
    return {
      studentId  : $("#student-number").val(),
      resident   : $("#resident-select").prop("selectedIndex"),
      lastName   : $("#last-name").val(),
      firstName  : $("#first-name").val(),
      initials   : $("#initials").val(),
      gender     : $("#gender").val(),
      dob        : $("#date-of-birth").val(),
      height     : $("#height").val(),
      weight     : $("#weight").val(),
      email      : $("#email").val(),
      hometown   : $("#hometown").val(),
      highSchool : $("#high-school").val(),
      gradYear   : $("#year-of-graduation").val(),
      program    : $("#program").val(),

      cStreet    : $("#current-street").val(),
      cCity      : $("#current-city").val(),
      cProvince  : $("#current-province").val(),
      cPostal    : $("#current-postal").val(),
      cCountry   : $("#current-country").val(),
      cPhone     : $("#current-phone").val(),

      pStreet    : $("#permanent-street").val(),
      pCity      : $("#permanent-city").val(),
      pProvince  : $("#permanent-province").val(),
      pPostal    : $("#permanent-postal").val(),
      pCountry   : $("#permanent-country").val(),
      pPhone     : $("#permanent-phone").val()
    };
  }

  init();

</script>