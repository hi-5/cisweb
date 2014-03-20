
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
			<button type='button' class='btn btn-primary' id='view-team-btn'>Check All</button>
			<form action="" method="POST" role="form">
				<div class="form-group" id="roster"></div>
				<button type="submit" class="btn btn-primary">Save Changes</button>
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
  }

  //Populates the team selection list
  function populateTeamList(result) {
    var htmlString = "";
    for (var i = 0; i < result.length; i++) {
      htmlString += "<option value='" + result[i].t_id + "'>" + result[i].t_name + "</option>";
    }
    $("#team-list").html(htmlString);
  }

  function viewTeam() {
  	var tid = $("#team-list option:selected").val();
  	var year = $("#year-select option:selected").val();


  	cislib.managerRequest("team", "getRosterTable", year, function(result){
  		var table = "";

  		table += "<table class='table table-striped table-condensed'>\n";
  		table += "<thead><th>ID</th><th>Last Name</th><th>First Name</th><th>Position</th><th>Jersey No.</th><th>Charged</th></thead>\n";
  		for (var i = 0; i < result.length; i++) {
     		table += "<tr>";
				table += "<td><a href='" + "?p=form&t=upd&i=" + result[i].a_studentId + "'>" + result[i].a_studentId + "</a></td>";
				table += "<td>" + result[i].a_lastName + "</td>";
				table += "<td>" + result[i].a_firstName + "</td>";
				table += "<td>" + result[i].ah_position + "</td>";
				table += "<td>" + result[i].ah_jerseyNumber + "</td>";
				table += "<td>" + result[i].ah_charged + "</td>";
				table += "</tr>\n";
    	}

    	table += "</table>\n";

  		$("#roster").html(table);
  	});

  }

	init();
 </script>