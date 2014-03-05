<!-- new row -->
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <select id="search-type" class="form-control">
        <option>Athlete by #</option>
        <option>Athlete by Last</option>
        <option>Athlete by First</option>
        <option>Teams by Year</option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
   <div class="form-group">
      <div class="input-group">
        <input id="search-text" type="text" class="form-control">
        <span class="input-group-btn">
          <button id="search-button" class="btn btn-default" type="button">Search</button>
        </span>
    </div>
    </div>
  </div>
</div>

<script>

  function init() {
    $("#search-button").click(searchButtonClick);
  }

  function searchButtonClick() {
    
    cislib.managerRequest("search", "get")
  }

  function redrawTable(result) {
    var tableString = "";
    for (var i = 0; i < result.length; i++)
      tableString += "<tr><td>" + result[i]["id"] + "</td><td>" + result[i]["last"] + ", " + result[i]["first"] + "</td><td>" + result[i]["type"] + 
                     "</td><td><a href='?p=form&t=box&i=" + result[i]["id"] + "'><button type='button' class='btn btn-xs btn-primary'>view</button></a></td></tr>";
    $("#inbox-forms").html(tableString);
  }

  init();

</script>