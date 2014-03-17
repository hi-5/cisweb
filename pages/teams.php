<br />
<table id="teams-table" class="table table-condensed">
  <thead>
    <tr>
      <th>ID</th>
      <th>Team Name</th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody id="teams-table-body">
  </tbody>
</table>

<script>

  function init() {
    $("#teams-table").css("display", "none");  
    cislib.managerRequest("team", "getYear", "2013", redrawTable);
  }

  function redrawTable(result) {
    console.log(result);
    if (result.length == 0) {
      //$("#inbox-body").html("There are no teams");
    } else {
      var tableString = "";
      for (var i = 0; i < result.length; i++) {
        tableString += "<tr>";
        tableString += "<td>" + result[i]["t_id"] + "</td>";
        tableString += "<td>" + result[i]["t_name"] + "</td>";
        tableString += "<td><button id='faculty-delete-button-" + i + "'type='button' class='btn btn-danger btn-xs'>delete</button></td>";
        tableString += "</tr>";
      }
      $("#teams-table-body").html(tableString);
      $("#teams-table").css("display", "block"); 
    }
  }

  init();

</script>