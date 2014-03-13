<!-- new row -->
<div class="row">
  <div class="col-md-6">
    <label for="team-list">Team</label>
    <select class="form-control" id="team-list"></select>
  </div>
</div>
<br />
<div class="row">
  <div class="col-md-3">
    <label for="order-select">Year</label>
    <select class="form-control" id="year-select"></select>
  </div>
  <div class="col-md-3">
    <label for="form-select">Report</label>
    <select class="form-control" id="report-select"></select>
    <input class="form-control hidden" id="new-report-name" placeholder="Enter Report Name">
  </div>
</div>
<br />
<div class="row">
<div id="report-builder" class="hidden">
  <div class="col-md-6">
    <label for="avail-attributes">Available Attributes</label>
    <select multiple class="form-control" id="avail-attributes">
    <option value="athletes.a_studentId">Student ID</option>
    <option value="athletes.a_lastName">Last Name</option>
    <option value="athletes.a_firstName">First Name</option>
    <option value="athletes.a_initials">Initials</option>
    <option value="athletes.a_gender">Gender</option>
    <option value="athletes.a_dob">DOB</option>
    <option value="athletes.a_height">Height</option>
    <option value="athletes.a_weight">Weight</option>
    <option value="athletes.a_email">Email</option>
    <option value="athletes.a_highSchool">High School</option>
    <option value="athletes.a_gradYear">Grad Year</option>
    <option value="athletes.a_program">Program</option>
    <option value="athletehistory.ah_position">Position</option>
    <option value="athletehistory.ah_jerseyNumber">Jersey Number</option>
    <option value="athletehistory.ah_charged">Eligibility Charged</option>
    <option value="YOE">Year of Eligibility</option>
    <option value="athletes.a_cStreet">Current Street</option>
    <option value="athletes.a_cCity">Current City</option>
    <option value="athletes.a_cProvince">Current Province</option>
    <option value="athletes.a_cPostalCode">Current Postal Code</option>
    <option value="athletes.a_cCountry">Current Country</option>
    <option value="athletes.a_cPhone">Current Phone Number</option>
    <option value="athletes.a_pStreet">Permanent Street</option>
    <option value="athletes.a_pCity">Permanent City</option>
    <option value="athletes.a_pProvince">Permanent Province</option>
    <option value="athletes.a_pPostalCode">Permanent Postal Code</option>
    <option value="athletes.a_pCountry">Permanent Country</option>
    <option value="athletes.a_pPhone">Permanent Phone Number</option>
    </select>
    <br />
    <button type="button" class="btn btn-primary" id="add-attribute-btn"><span class='glyphicon glyphicon-arrow-down'></span> Add</button>
    <button type="button" class="btn btn-primary" id="remove-attribute-btn"><span class='glyphicon glyphicon-arrow-up'></span> Remove</button>
  </div>
    <br />
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <label for="selected-attributes">Selected Attributes</label>
          <select multiple class="form-control" id="selected-attributes"></select>
        </div>
        <div class="col-md-2">
          <br />
          <br />
          <button type="button" class="btn btn-primary" id="move-up-btn"><span class='glyphicon glyphicon-arrow-up'></span></button>
          <br />
          <button type="button" class="btn btn-primary" id="move-down-btn"><span class='glyphicon glyphicon-arrow-down'></span></button>
        </div>
      </div>
    </div>
    <br />
    <div class="col-md-3">
      <label for="order-select">Order By</label>
      <select class="form-control" id="order-select"></select>
    </div>
  </div>
</div>
<br />
<div class="row">
  <div class="col-md-6">
    <button type="button" class="btn btn-primary" id="excel-btn"><span class='glyphicon glyphicon-save'></span> Excel</button>
    <button type="button" class="btn btn-primary" id="web-btn"><span class='glyphicon glyphicon-globe'></span> Web</button>
    <button type="button" class="btn btn-primary" id="preview-btn"><span class='glyphicon glyphicon-eye-open'></span> Preview</button>
    <button type="button" class="btn btn-success" id="new-report-btn"><span class='glyphicon glyphicon-plus'></span> New</button>
    <button type="button" class="btn btn-danger" id="del-report-btn"><span class='glyphicon glyphicon-remove'></span> Delete</button>
    <button type="button" class="btn btn-success hidden" id="save-report-btn"><span class='glyphicon glyphicon-plus'></span> Save</button>
    <button type="button" class="btn btn-danger hidden" id="cancel-report-btn"><span class='glyphicon glyphicon-remove'></span> Cancel</button>
  </div>
</div>
<br />
<div class="row">
  <div class="col-md-12" id="preview-holder"></div>
</div>

<!-- Hidden info used in JS goes here -->
<form id="web-form" method="post" action="/php/report.php" class="hidden">
<!-- Holds JSON string for POST -->
<input type="text" name="js" id="json-holder">
<!-- Holds format type -->
<input type="text" name="format" id="format-holder">
<!-- Holds mode (custom or saved) -->
<input type="text" name="format" id="mode-holder" value="saved">
</form>

<script type="text/javascript">

  function init() {
    addEventListeners();
    populateReportList();

    for (i = new Date().getFullYear(); i > 1900; i--) {
      $('#year-select').append($('<option />').val(i).html(i + "-" + (i+1)));
    }
  }

  function addEventListeners() {
    $("#add-attribute-btn").click(addAttribute);
    $("#remove-attribute-btn").click(removeAttribute);
    $("#move-up-btn").click(moveAtriUp);
    $("#move-down-btn").click(moveAtriDown);
    $("#preview-btn").click(previewReport);
    $("#web-btn").click(webReport);
    $("#excel-btn").click(excelReport);
    $("#new-report-btn").click(toggleBuilder);
    $("#cancel-report-btn").click(toggleBuilder);
    $("#save-report-btn").click(saveReport);
    $("#report-select").change(getReportString);

  }

  //Adds and attribute to the bottom list and order select
  function addAttribute() {
    var val = $('#avail-attributes option:selected');
    $('#avail-attributes option:selected').next().attr('selected', 'selected');
    $('#selected-attributes').append(val.clone());
    $('#order-select').append(val);
  }

  //Removes an attribute from the bottom list and order select
  function removeAttribute() {
    var val = $('#selected-attributes option:selected');
    val.remove();
    $('#order-select option:' + val.val()).remove();
  }

  //Moves selected attribute up on the list
  function moveAtriUp() {
    $('#selected-attributes option:selected').prev().before($('#selected-attributes option:selected'));
  }

  //Moves selected attribute down on the list
  function moveAtriDown() {
    $('#selected-attributes option:selected').next().after($('#selected-attributes option:selected'));
  }

  //Populates the team selection list
  function populateTeamList(result) {

  }

  //Populates the report selection list with all reports in the DB
  function populateReportList () {
    $.ajax({
        type     : 'POST',
        url      : 'php/reportsLib.php',
        dataType : 'json',
        data     : {action: "getList"},
        cache    : false,
        success  : function(result) {
          var reportString = "";
          for (var i = 0; i < result.length; i++) {
            reportString += "<option value='" + result[i].r_id + "'>" + result[i].r_name + "</option>\n";
          }
          $("#report-select").append(reportString);
          //Puts the inital report string into the holder before the user makes a selection
          getReportString();
        },
        error    : function(a, b, c) {
          console.log('Error:');
          console.log(a);
          console.log(b);
          console.log(c);
        }
    }); 
  }

  function toggleBuilder() {
    $("#report-builder").toggleClass("hidden");
    $("#report-select").toggleClass("hidden");
    $("#new-report-name").toggleClass("hidden");
    $("#new-report-btn").toggleClass("hidden");
    $("#del-report-btn").toggleClass("hidden");
    $("#save-report-btn").toggleClass("hidden");
    $("#cancel-report-btn").toggleClass("hidden");

    var mode = $("#mode-holder").val();

    if (mode == "saved") {
      $("#mode-holder").val("new");
    } else {
      $("#mode-holder").val("saved");
    }

  }

  //creates a JSON object from all attributes in the selected box
  //as well as the year, order and team selected.
  function createJSON() {
    
    var colName;
    var colHeader;
    var order;
    var team;
    var length = $('#selected-attributes option').size();
    var year = $('#year-select option:selected').val();
    var format = $("#format-holder").val();

    order = $('#order-select option:selected').val();
    team = 1;

    //start JSON string
    var js = "{";
    js += "\"order\": " + "\"" + order + "\","
    js += "\"team\": " + "\"" + team + "\","
    js += "\"length\": " + "\"" + length + "\","
    js += "\"year\": " + "\"" + year + "\","
    js += "\"format\": " + "\"" + format + "\","
    js += "\"attributes\": {"

    for (var i = 0; i < length; i++) {

      //get variables
      colName = $('#selected-attributes :nth-child(' + (i+1) + ')').val();
      colHeader = $('#selected-attributes :nth-child(' + (i+1) + ')').text();


      js += "\"" + i + "\": ";
      js += "{\"name\": \"" + colName + "\", ";
      js += "\"header\": \"" + colHeader + "\"}";

      //adds comma for next attribute if not last attribute.
      if (i != length-1) js += ',';
    }
    
    //close JSON string
    js += "}}";

    return js;
  }

  //This function gets the JSON query string from the DB and
  //then places the JSON query string into the holder.
  function getReportString() {
    var reportId = $("#report-select option:selected").val();
    $.ajax({
        type     : 'POST',
        url      : 'php/reportsLib.php',
        dataType : 'json',
        data     : {action: "getString",
                    id: reportId},
        cache    : false,
        success  : function(result) {
          $("#json-holder").val(result.r_string);
        },
        error    : function(a, b, c) {
          console.log('Error:');
          console.log(a);
          console.log(b);
          console.log(c);
        }
    }); 
  }

  //This function takes a report JSON string and alters it with new team and year information.
  //This is required because the database stores the entire JSON query 
  // string including the year and team when it was created
  function adjustString(json) {
    var obj = JSON.parse(json);
    obj.team = 1;
    obj.year = $('#year-select option:selected').val();
    obj.format = $("#format-holder").val();
    var string = JSON.stringify(obj);
    return string;

  }

  function saveReport() {
    var json = createJSON();
    var reportName = $("#new-report-name").val();
    $.ajax({
      type     : 'POST',
      url      : 'php/reportsLib.php',
      data     : {action: "add",
                  name: reportName,
                  string: json},
      cache    : false,
      success  : function(result) {
        $("#preview-holder").html(result);
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    }); 
  }

  //Does AJAX request to generate a sample table of the report on same page
  function previewReport() {
    var mode = $("#mode-holder").val();
    $("#format-holder").val("web");

    if (mode == "saved") {
      getReportString();
      $("#json-holder").val(adjustString($("#json-holder").val()));
    } else if (mode == "new") {
      $("#json-holder").val(createJSON);
    }
    
    var json = $("#json-holder").val();
    console.log(json);

    $.ajax({
      type     : 'POST',
      url      : 'php/generateReport.php',
      data     : {"js": json},
      cache    : false,
      success  : function(result) {
        $("#preview-holder").html(result)
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    }); 
  }

  //generates and saves a xls file`
  function excelReport() {
    $("#format-holder").val("excel");
  }

  //generates the report in a printable format on next page
  function webReport() {
    var mode = $("#mode-holder").val();
    $("#format-holder").val("web");

    if (mode == "saved") {
      getReportString();
      $("#json-holder").val(adjustString($("#json-holder").val()));
    } else if (mode == "new") {
      $("#json-holder").val(createJSON);
    }

    $("#web-form").submit();
  }

  init();

</script>