<div id="inbox-notice"></div>
<div class="panel panel-default">
  <div class="panel-heading">Inbox</div>
  <div id="inbox-body" class="panel-body">
    <table id="inbox-table" class="table table-condensed">
      <thead>
        <tr>
          <td>Student #</td>
          <td>Athlete Name</td>
          <td>Type</td>
          <td>&nbsp</td>
        </tr>
      </thead>
      <tbody id="inbox-table-body">
      </tbody>
    </table>
  </div>
</div>

<script>

  function init() {
    displayNotice();
    $("#reg-team-table").css("display", "none");  
    cislib.managerRequest("inbox", "retrieve", undefined, redrawTable);
  }

  function displayNotice() {
    var r = cislib.getURLParameter("r");
    if (r) {
      switch(r) {
        case "app":
          $("#inbox-notice").html("<div class='alert alert-success'>Athlete form was successfully approved.</div>");
          break;
        case "appf":
          $("#inbox-notice").html("<div class='alert alert-danger'>Athlete form failed to approve.</div>");
          break;
        case "del":
          $("#inbox-notice").html("<div class='alert alert-success'>Athlete form was successfully deleted.</div>");
          break;
        case "delf":
          $("#inbox-notice").html("<div class='alert alert-danger'>Athlete form failed to delete.</div>");
          break;
      }
    }
  }

  function redrawTable(result) {
    if (result.length == 0) {
      $("#inbox-body").html("There is nothing waiting in the inbox...");
    } else {
      var tableString = "";
      for (var i = 0; i < result.length; i++)
        tableString += "<tr><td>" + result[i]["id"] + "</td><td>" + result[i]["last"] + ", " + result[i]["first"] + "</td><td>" + result[i]["type"] + 
                       "</td><td><a href='?p=form&t=app&i=" + result[i]["id"] + "'><button type='button' class='btn btn-xs btn-primary'>view</button></a></td></tr>";
      $("#inbox-table-body").html(tableString);
    }
    
  }

  init();

</script>