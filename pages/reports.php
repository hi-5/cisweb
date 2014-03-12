<!-- new row -->
<div class="row">
  <div class="col-md-6">
    <label for="team-list">Team</label>
    <select class="form-control" id="team-list"></select>
  </div>
</div>
<br />
<div class="row">
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
<div class="row">
  <div class="col-md-3">
    <label for="order-select">Year</label>
    <select class="form-control" id="year-select"></select>
  </div>
  <div class="col-md-3">
    <label for="order-select">Order By</label>
    <select class="form-control" id="order-select"></select>
  </div>
</div>
<br />
<div class="row">
  <button type="button" class="btn btn-primary" id="excel-btn"><span class='glyphicon glyphicon-save'></span> Excel</button>
  <button type="button" class="btn btn-primary" id="web-btn"><span class='glyphicon glyphicon-globe'></span> Web</button>
  <button type="button" class="btn btn-primary" id="preview-btn"><span class='glyphicon glyphicon-eye-open'></span> Preview</button>
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
</form>

<script type="text/javascript">

  function init() {
    addEventListeners();

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

  //creates a JSON object from all attributes in the selected box
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
    var js = "{\n";
    js += "\"order\": " + "\"" + order + "\",\n"
    js += "\"team\": " + "\"" + team + "\",\n"
    js += "\"length\": " + "\"" + length + "\",\n"
    js += "\"year\": " + "\"" + year + "\",\n"
    js += "\"format\": " + "\"" + format + "\",\n"
    js += "\"attributes\": {"

    for (var i = 0; i < length; i++) {

      //get variables
      colName = $('#selected-attributes :nth-child(' + (i+1) + ')').val();
      colHeader = $('#selected-attributes :nth-child(' + (i+1) + ')').text();


      js += "\n\"" + i + "\": ";
      js += "{\"name\": \"" + colName + "\", ";
      js += "\"header\": \"" + colHeader + "\"}";

      //adds comma for next attribute if not last attribute.
      if (i != length-1) js += ',';
    }
    
    //close JSON string
    js += "\n}\n}";

    console.log(js);
    return js;
  }

  //Does AJAX request to generate a sample table of the report on same page
  function previewReport() {
    $("#format-holder").val("web");
    $("#json-holder").val(createJSON);
    var json = $("#json-holder").val()
    $.ajax({
      type     : 'POST',
      url      : 'php/report.php',
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

  //generates and saves a xls file
  function excelReport() {
    $("#format-holder").val("excel");
  }

  //generates the report in a printable format on next page
  function webReport() {
    $("#format-holder").val("web");
    $("#json-holder").val(createJSON);
    $("#web-form").submit();
  }

  init();

</script>