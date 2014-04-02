<?php

  include "./php/cislib.php";
  loggedAdmin();

?>


<form class="form-inline">
	<label for="inputTeam">Team </label>
	<select name="team" id="team-list" class="form-control">
	</select>
	<label for="inputYear"> Year </label>
	<select name="year" id="year-select" class="form-control">
	</select>
	<button type="button" class="btn btn-primary" id="view-team-btn">View</button>
</form>
<br>
<div class="panel panel-default">
	  <div class="panel-heading">
			<h3 class="panel-title">Roster</h3>
	  </div>
	  <div class="panel-body">
	  	<div id="header-holder"></div>
			<button type='button' class='btn btn-primary pull-right' id='check-all-btn'>Check All</button>
			<br>
			<form role="form" id="roster-form">
				<div class="form-group" id="roster"></div>
				<button type="button" class="btn btn-primary pull-right" id="submit-elig-btn">Save Changes</button>
				<br><br>
				<div class="alert alert-success hidden" id="elig-success">Success, eligibility info updated!</div>
			</form>
	  </div>
</div>
<div class="panel panel-default">
	  <div class="panel-heading">
			<h3 class="panel-title">Faculty</h3>
	  </div>
	  <div class="panel-body">
			<form class="form-inline">
				<label for="coach-select">Coach</label>
				<select name="coach-select" id="coach-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
				<label for="asscoach-select">Assistant Coach</label>
				<select name="asscoach-select" id="asscoach-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
				<label for="manager-select">Manager</label>
				<select name="manager-select" id="manager-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
			</form>
			<br>
			<form class="form-inline">
				<label for="trainer-select">Trainer</label>
				<select name="trainer-select" id="trainer-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
				<label for="doctor-select">Doctor</label>
				<select name="doctor-select" id="doctor-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
				<label for="therapist-select">Therapist</label>
				<select name="therapist-select" id="therapist-select" class="form-control faculty-select">
				<option value="0">None</option>
				</select>
			</form>
			<br>
			<button type="button" class="btn btn-primary" id="save-staff-btn">Save Changes</button>
			<br><br>
			<div class="alert alert-success hidden" id="fac-success">Success, faculty info updated!</div>
	  </div>
</div>

<script type="text/javascript">

 	function init() {
    addEventListeners();

    cislib.managerRequest("team", "getList", undefined, populateTeamList);
    cislib.managerRequest("faculty", "getAll", undefined, populateFacultySelects);

    for (i = new Date().getFullYear(); i > 1900; i--) {
      $('#year-select').append($('<option />').val(i).html(i + "-" + (i+1)));
    }
  }

  function addEventListeners() {
  	$("#view-team-btn").click(viewTeam);
  	$("#submit-elig-btn").click(submitEligibility);
  	$("#check-all-btn").click(checkAll);
  	$("#save-staff-btn").click(saveFaculty);
  }

  //Populates the team selection list
  function populateTeamList(result) {
    var htmlString = "";
    for (var i = 0; i < result.length; i++) {
      htmlString += "<option value='" + result[i].t_id + "'>" + result[i].t_name + "</option>";
    }
    $("#team-list").html(htmlString);
  }

  //Generates a table for the selected team and year with check boxes for eligibility
  function viewTeam() {
  	var tid = $("#team-list option:selected").val();
  	var year = $("#year-select option:selected").val();

  	var obj = new Object();
  	obj.team = tid;
  	obj.year = year;

  	var string = JSON.stringify(obj);

  	//Get the team roster and build the table.
  	cislib.managerRequest("team", "getRosterTable", string, function(result){
  		var table = "";

  		table += "<table class='table table-striped table-condensed' id='roster-table'>\n";
  		table += "<thead><th>ID</th><th>Last Name</th><th>First Name</th><th>Position</th><th>Jersey No.</th><th>Charged</th></thead>\n";
  		for (var i = 0; i < result.length; i++) {
  			var charged;
  			if (result[i].ah_charged == 1) charged = "checked";
  			else charged = "unchecked";

     		table += "<tr>";
				table += "<td><a href='" + "?p=form&t=upd&i=" + result[i].a_studentId + "'>" + result[i].a_studentId + "</a></td>";
				table += "<td>" + result[i].a_lastName + "</td>";
				table += "<td>" + result[i].a_firstName + "</td>";
				table += "<td>" + result[i].ah_position + "</td>";
				table += "<td>" + result[i].ah_jerseyNumber + "</td>";
				table += "<td><input class='elig-check' type='checkbox' value='" + result[i].a_studentId + "' name='" + i + "' " + charged + " ></td>";
				table += "</tr>\n";
    	}

    	table += "</table>\n";

    	var header = "<h2>" + $("#team-list option:selected").html() + ", " + $("#year-select option:selected").html() + "</h2>\n";

    	//Print header and table
    	$("#header-holder").html(header);
  		$("#roster").html(table);
  	});

		//Set team faculty
		cislib.managerRequest("team", "getFaculty", string, function(result){
			var coach;
			var assCoach;
			var manager;
			var trainer;
			var doctor;
			var therapist;

			if (result.t_headCoachId) coach = result.t_headCoachId;
			else coach = 0;
			if (result.t_asstCoachId != undefined) assCoach = result.t_asstCoachId;
			else assCoach = 0;
			if (result.t_managerId != undefined) manager = result.t_managerId;
			else manager = 0;
			if (result.t_trainerId != undefined) trainer = result.t_trainerId;
			else trainer = 0;
			if (result.t_doctorId != undefined) doctor = result.t_doctorId;
			else doctor = 0;
			if (result.t_therapistId != undefined) therapist = result.t_therapistId;
			else therapist = 0;

			$("#coach-select").val(coach);
			$("#asscoach-select").val(assCoach);
			$("#manager-select").val(manager);
			$("#trainer-select").val(trainer);
			$("#doctor-select").val(doctor);
			$("#therapist-select").val(therapist);
		});

		//Hides the success alert if active
		toggleEligSuccessAlert("hide");
		toggleFacSuccessAlert("hide");
  }

  //Checks all eligibility charged check boxes.
  function checkAll() {
    $(".elig-check").each(function(index){
  		$(this).prop('checked', true);
  	});
  }

  //Updates the eligibility field for all athletes in the roster.
  function submitEligibility() {

  	var array = new Array()
  	var year = $("#year-select option:selected").val();

  	//for each check box in the table add to json object.
  	var i = 0;
  	var id
  	var val;

  	//get values and id for each check box.
  	$(".elig-check").each(function(index){
  		id = $(this).val();
  		
  		if ($(this).is(':checked')) {
  			val = 1;
  		} else {
  			val = 0;
  		}
  		array[i] = [id, val, year];
  		i++;
  	});

  	var string = JSON.stringify(array);

  	cislib.managerRequest("team", "updateEligibility", string, function(result){
  		if (result == "success") toggleEligSuccessAlert("show");
  	});
  }

  //expects show or hide to toggle set display of alert message
  function toggleEligSuccessAlert(arg) {
  	if (arg == "hide") $("#elig-success").addClass("hidden");
  	else if (arg == "show")
  	$("#elig-success").toggleClass("hidden");
  }

    //expects show or hide to toggle set display of alert message
  function toggleFacSuccessAlert(arg) {
  	if (arg == "hide") $("#fac-success").addClass("hidden");
  	else if (arg == "show")
  	$("#fac-success").toggleClass("hidden");
  }

  //Populates the select boxes with all faculty
  function populateFacultySelects(result) {
		var htmlString = "";
		for (var i = 0; i < result.length; i++) {
			htmlString += "<option value='" + result[i].f_studentId + "'>" + result[i].f_lastName + ", " + result[i].f_firstName + "</option>";
		}
		$(".faculty-select").append(htmlString);
  }

  //Updates all faculty in the selected team/year with selected values.
  function saveFaculty() {
  	var tid = $("#team-list option:selected").val();
  	var year = $("#year-select option:selected").val();
  	var coach = $("#coach-select").val();
  	var assCoach = $("#asscoach-select").val();
  	var manager = $("#manager-select").val();
  	var trainer = $("#trainer-select").val();
  	var doctor = $("#doctor-select").val();
  	var therapist =$("#therapist-select").val();

  	var obj = new Object();
  	obj.team = tid;
  	obj.year = year;
  	obj.coach = coach;
  	obj.assCoach = assCoach;
  	obj.manager = manager;
  	obj.trainer = trainer;
  	obj.doctor = doctor;
  	obj.therapist = therapist;

  	var string = JSON.stringify(obj);

  	cislib.managerRequest("team", "saveFaculty", string, function(result){
  		if (result == "success") toggleFacSuccessAlert("show");
  	})
  }

	init();
 </script>