<!-- new row -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
    <label for="team-list">Team</label>
    <select class="form-control" id="team-list"></select>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="avail-attributes">Available Attributes</label>
      <select multiple class="form-control" id="avail-attributes">
        <option value="a_studentId">Student ID</option>
        <option value="a_lastName">Last Name</option>
        <option value="a_firstName">First Name</option>
        <option value="a_initials">Initials</option>
        <option value="a_gender">Gender</option>
        <option value="a_dob">DOB</option>
        <option value="a_height">Height</option>
        <option value="a_weight">Weight</option>
        <option value="a_email">Email</option>
        <option value="a_highSchool">High School</option>
        <option value="a_gradYear">Grad Year</option>
        <option value="a_program">Program</option>
        <option value="athletehistory.ah_position">Position</option>
        <option value="athletehistory.jerseyNumber">Jersey Number</option>
        <option value="athletehistory.ah_charged">Eligibility Charged</option>
        <option value="YOE">Year of Eligibility</option>
        <option value="a_cStreet">Current Street</option>
        <option value="a_cCity">Current City</option>
        <option value="a_cProvince">Current Province</option>
        <option value="a_cPostalCode">Current Postal Code</option>
        <option value="a_cCountry">Current Country</option>
        <option value="a_cPhone">Current Phone Number</option>
        <option value="a_pStreet">Permanent Street</option>
        <option value="a_pCity">Permanent City</option>
        <option value="a_pProvince">Permanent Province</option>
        <option value="a_pPostalCode">Permanent Postal Code</option>
        <option value="a_pCountry">Permanent Country</option>
        <option value="a_pPhone">Permanent Phone Number</option>
      </select>
    <br />
    <button type="button" class="btn btn-primary" id="add-attribute-btn"><span class='glyphicon glyphicon-arrow-down'></span> Add</button>
    <button type="button" class="btn btn-primary" id="remove-attribute-btn"><span class='glyphicon glyphicon-arrow-up'></span> Remove</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="selected-attributes">Selected Attributes</label>
      <select multiple class="form-control" id="selected-attributes"></select>
      <br />
      <button type="button" class="btn btn-primary" id="excel-btn"><span class='glyphicon glyphicon-save'></span> Excel</button>
      <button type="button" class="btn btn-primary" id="web-btn"><span class='glyphicon glyphicon-globe'></span> Web</button>
      <button type="button" class="btn btn-primary" id="preview-btn"><span class='glyphicon glyphicon-eye-open'></span> Preview</button>
    </div>
  </div>
</div>

<script type="text/javascript">

  function init() {
    addEventListeners();
  }

  function addEventListeners() {
    $("#add-attribute-btn").click(addAttribute);
    $("#remove-attribute-btn").click(removeAttribute);
    $("#preview-btn").click(createJSON);
  }

  //Adds and attribute to the bottom list
  function addAttribute() {
    $('#selected-attributes').append($('#avail-attributes option:selected'));
  }

  //Removes an attribute from the bottom list
  function removeAttribute() {
    $('#selected-attributes option:selected').remove();
  }

  //Populates the team selection list
  function populateTeamList(result) {
    var htmlString = "";
    for (var i = 0; i < result.length; i++) {
      teamList.push({
        id   : result[i].t_id,
        name : result[i].t_name
      });
      htmlString += "<option>" + result[i].t_name + "</option>";
    }
    $("#team-list").html(htmlString);
  }

  //creates a JSON object from all attributes in the selected box
  function createJSON() {
    var jsonstring = "{";
    var colName;
    var colHeader;
    var length = $('#selected-attributes option').size();

    for (var i = 0; i < length; i++) {
      colName = $('#selected-attributes :nth-child(' + (i+1) + ')').val();
      colHeader = $('#selected-attributes :nth-child(' + (i+1) + ')').text();
      jsonstring += "\n\"" + colName + "\": ";
      jsonstring += "\"" + colHeader + "\"";
      //adds comma for next attribute if not last attribute.
      if (i != length-1) jsonstring += ',';
    }
    jsonstring += "\n}";
    console.log(jsonstring);
    return jsonstring;
  }

  //Does AJAX request to generate a sample table of the report on same page
  function previewReport() {

  }

  //generates and saves a xls file
  function excelReport() {

  }

  //generates the report in a printable format on next page
  function webReport() {

  }

  init();

</script>