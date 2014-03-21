
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
			</form>
	  </div>
</div>
<div class="panel panel-default">
	  <div class="panel-heading">
			<h3 class="panel-title">Faculty</h3>
	  </div>
	  <div class="panel-body">
			Panel content
	  </div>
</div>

<script type="text/javascript">

 	function init() {
    addEventListeners();

    cislib.managerRequest("team", "getList", undefined, populateTeamList);

    for (i = new Date().getFullYear(); i > 1900; i--) {
      $('#year-select').append($('<option />').val(i).html(i + "-" + (i+1)));
    }
  }

  function addEventListeners() {
  	$("#view-team-btn").click(viewTeam);
  	$("#submit-elig-btn").click(submitEligibility);
  	$("#check-all-btn").click(checkAll);
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

    	$("#header-holder").html(header);
  		$("#roster").html(table);
  	});

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

  	console.log(string);
  	cislib.managerRequest("team", "updateEligibility", string, function(result){
  		// console.log(result);
  	});
  }

	init();
 </script>