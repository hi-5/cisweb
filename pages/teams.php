<h1>Teams</h1>

<!-- new row -->
<div class="row">

  <div class="col-md-10">
    <!-- new row -->
    <div class="row">
      <div class="col-md-8">
        <form role="form">
          <div class="form-group">
            <button type="button" class="btn btn-primary" id="team-new-button">New Team</button>
            <section id="teamField" class="hidden">
              <label>Team Name</label>
              <input name="name" class="form-control" id="team-name" placeholder="Team Name">
              <button type="button" class="btn btn-primary" id="team-add-button">Add Team</button>
              <button type="button" class="btn btn-danger" id="team-cancel-button">Cancel</button>
            </section>
          </div>
        </form>
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

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirm-del-modal">
  Temp
</button>

<!-- Modal -->
<div class="modal fade" id="confirm-del-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>

  //Creates event listeners and calls initial page displays
  function init() {
    console.log("test1");
    addEventListeners();
    listTeams();
  }

  //Button Listeners
  function addEventListeners() {
    $("#team-new-button").click(showForm);
    $("#team-cancel-button").click(showForm);
    $("#team-add-button").click(addTeam);
    $(document).on('click', ".edit-btn", function() {
      var id = $(this).closest("tr").attr("id");
      displayEdit(id);       
    });
    $(document).on('click', ".del-btn", function() {
      var id = $(this).closest("tr").attr("id");
      deleteTeam(id);       
    });
    $(document).on('click', ".change-btn", function() {
      var id = $(this).closest("tr").attr("id");
      editTeam(id);       
    });
    $(document).on('click', ".cancel-btn", function() {
      var id = $(this).closest("tr").attr("id");
      displayEdit(id);       
    });
  }

  // Gets a JSON array of all teams and generates/outputs a table based on that data
  function listTeams() {
    $.ajax({
        type     : 'POST',
        url      : 'php/teammanager.php',
        dataType : 'json',
        data     : { action : "list"},      
        cache    : false,
        success  : function( result ) {
          var table = "<table class='table'>";
          for (var i = 0; i < result.length; i++) {
            table += "<tr id='" + result[i].t_id  + "'>" 
                  + "<td><a href='#'>" + result[i].t_description + "</a></td>"
                  + "<td class='hidden'><input name='name' class='form-control'></td>"
                  + "<td><button type='button' class='btn btn-default btn-sm edit-btn'>" 
                  + "<span class='glyphicon glyphicon-edit'></span></button>"
                  + "<button type='button' class='btn btn-danger btn-sm del-btn'>"
                  + "<span class='glyphicon glyphicon-remove'></span></button></td>"
                  + "<td class='hidden'><button type='button' class='btn btn-success btn-sm change-btn'>"
                  + "<span class='glyphicon glyphicon-ok-circle'></span></button>"
                  + "<button type='button' class='btn btn-danger btn-sm cancel-btn'>"
                  + "<span class='glyphicon glyphicon-remove-circle'></span></button></td>"
                  + "</tr>";
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

  //Toggles the add team form.
  function showForm () {
    $("#teamField").toggleClass("hidden");
    $("#team-new-button").toggleClass("hidden");
  }

  //Adds a team to the database with the name in the team-name feild.
  function addTeam() {
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
        showForm();
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  //Allows user to edit the name of selected team
  //Toggles the visibility of a form element within the table and the name link.
  //Editing the form and submitting will replace the team name.
  function displayEdit( id ) {
    $("#" + id).children('td').eq(0).toggleClass("hidden");
    var name = $("#" + id).children('td').eq(0).children('a').html();
    $("#" + id).children('td').eq(1).toggleClass("hidden");
    $("#" + id).children('td').eq(1).children('input').val(name);

    $("#" + id).children('td').eq(2).toggleClass("hidden");
    $("#" + id).children('td').eq(3).toggleClass("hidden");
  }

  function editTeam( id ) {
    var n = $("#" + id).children('td').eq(1).children('input').val();
    $.ajax({
      type     : 'POST',
      url      : 'php/teammanager.php',
      data     : {action : "update",
                  args : id,
                  name : n},
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

  //Deletes the team where id = t_id
  function deleteTeam ( id ) {
    $.ajax({
      type     : 'POST',
      url      : 'php/teammanager.php',
      data     : {action : "delete",
                  args : id},
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