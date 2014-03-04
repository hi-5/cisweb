<table class="table table-condensed">
  <thead>
    <tr>
      <td>Student #</td>
      <td>Athlete Name</td>
      <td>Type</td>
      <td>&nbsp</td>
    </tr>
  </thead>
  <tbody id="inbox-mail">
  </tbody>
</table>

<script>

  function init() {
    getInbox();
  }

  function getInbox() {
    $.ajax({
      type     : 'POST',
      url      : 'php/inboxmanager.php',
      dataType : 'json',
      data     : { 
        action : 'retrieve'
      },
      cache    : false,
      success  : function( result ) {
        redrawTable(result);
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  function redrawTable(result) {
    var tableString = "";
    for (var i = 0; i < result.length; i++)
      tableString += "<tr><td>" + result[i]["id"] + "</td><td>" + result[i]["last"] + ", " + result[i]["first"] + "</td><td>" + result[i]["type"] + "</td><td><button type='button' class='btn btn-xs btn-primary'>view</button></td></tr>";
    $("#inbox-mail").html(tableString);
  }

  init();

</script>