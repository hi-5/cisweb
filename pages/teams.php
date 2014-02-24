<h1>Teams</h1>

<!-- new row -->
<div class="row">

  <div class="col-md-10">
    <!-- new row -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <button type="button" class="btn btn-primary" id="team-new-button">New Team</button>
          <section id="teamField" class="hidden">
            <label>Team Name</label>
            <input name="name" class="form-control" id="team-name" placeholder="Team Name">
            <button type="button" class="btn btn-primary" id="team-add-button">Add Team</button>
          </section>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-10">
    <!-- new row -->
    <div class="row">
      <div class="col-md-6" id="content">
      </div>
    </div>
  </div>
</div>

<script>
  // Gets a JSON array of all teams and generates/outputs a table based on that data
  function listTeams() {
    $.ajax({
        type     : 'POST',
        url      : 'php/teammanager.php',
        dataType : 'json',
        data     : { action : "list"},      
        cache    : false,
        success  : function( result ) {
          var table = "<table class='table'><tr><th>ID</th><th>Name</th></tr>";
          for (var i = 0; i < result.length; i++) {
            table += "<tr><td>" + result[i].t_id + "</td><td>" + result[i].t_description + "</td><td><button type='button' class='btn btn-default btn-lg'><span class='glyphicon glyphicon-edit'></span></button></td></tr>";
          }
          table += "</table>";
          $("#content").html(table);
        },
        error    : function(a, b, c) {
          console.log('Error:');
          console.log(a);
          console.log(b);
          console.log(c);
        }
      });
  }

  function init() {
    console.log("test9");
    addEventListeners();
    listTeams();
  }

  //Button Listeners
  function addEventListeners() {
    $("#team-new-button").click(showForm);
    $("#team-add-button").click(addTeam);
  }

  //Toggles the add team form.
  function showForm () {
    console.log("test1");
    $("#teamField").toggleClass("hidden");
    $("#team-new-button").toggleClass("hidden");
  }

  //Adds a team to the database with the name in the team-name feild.
  function addTeam( event ) {
    var name = $("#team-name").val();
    console.log(name);
      $.ajax({
      type     : 'POST',
      url      : 'php/teammanager.php',
      data     : {action : "add",
                  args : name},
      cache    : false,
      success  : function() {
        listTeams();
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  init();

</script>