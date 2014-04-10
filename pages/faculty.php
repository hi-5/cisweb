<?php

  loggedAdmin();

?>

<br />

<button id="faculty-add-button" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#faculty-modal">Add New Faculty +</button>

<ul class="pagination pagination-sm">
  <li><a href="?p=sett&t=facl&l=a">A</a></li>
  <li><a href="?p=sett&t=facl&l=b">B</a></li>
  <li><a href="?p=sett&t=facl&l=c">C</a></li>
  <li><a href="?p=sett&t=facl&l=d">D</a></li>
  <li><a href="?p=sett&t=facl&l=e">E</a></li>
  <li><a href="?p=sett&t=facl&l=f">F</a></li>
  <li><a href="?p=sett&t=facl&l=g">G</a></li>
  <li><a href="?p=sett&t=facl&l=h">H</a></li>
  <li><a href="?p=sett&t=facl&l=i">I</a></li>
  <li><a href="?p=sett&t=facl&l=j">J</a></li>
  <li><a href="?p=sett&t=facl&l=k">K</a></li>
  <li><a href="?p=sett&t=facl&l=l">L</a></li>
  <li><a href="?p=sett&t=facl&l=m">M</a></li>
  <li><a href="?p=sett&t=facl&l=n">N</a></li>
  <li><a href="?p=sett&t=facl&l=o">O</a></li>
  <li><a href="?p=sett&t=facl&l=p">P</a></li>
  <li><a href="?p=sett&t=facl&l=q">Q</a></li>
  <li><a href="?p=sett&t=facl&l=r">R</a></li>
  <li><a href="?p=sett&t=facl&l=s">S</a></li>
  <li><a href="?p=sett&t=facl&l=t">T</a></li>
  <li><a href="?p=sett&t=facl&l=u">U</a></li>
  <li><a href="?p=sett&t=facl&l=v">V</a></li>
  <li><a href="?p=sett&t=facl&l=w">W</a></li>
  <li><a href="?p=sett&t=facl&l=x">X</a></li>
  <li><a href="?p=sett&t=facl&l=y">Y</a></li>
  <li><a href="?p=sett&t=facl&l=z">Z</a></li>
</ul>

<div id="faculty-notice">
</div>

<!-- table of athletic faculty -->
<table id="faculty-table" class="table">
  <thead>
    <tr>
      <th>Student #</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Admin</th>
      <th>&nbsp</th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody id="faculty-table-body">
    <!-- populates with faculty information -->
  </tbody>
</table>

<!-- add/update record modal -->
<div class="modal fade" id="faculty-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="faculty-modal-label" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
        <!-- new row -->
        <div class="row">
          <div class="col-md-4">
           <div class="form-group">
              <label>Student #</label>
              <input id="faculty-modal-student-num" type="input" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
           <div class="form-group">
              <label>Last Name</label>
              <input id="faculty-modal-last-name" type="input" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
           <div class="form-group">
              <label>First Name</label>
              <input id="faculty-modal-first-name" type="input" class="form-control" placeholder="">
            </div>
          </div>
        </div>

        <!-- new row -->
        <div class="row">
          <div class="col-md-4">
           <div class="form-group">
              <label>Phone</label>
              <input id="faculty-modal-phone" type="input" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-4">
           <div class="form-group">
              <label>Email</label>
              <input id="faculty-modal-email" type="input" class="form-control" placeholder="">
            </div>
          </div>
          <div class="col-md-2">
           <div class="form-group">
              <label>&nbsp</label>
              <div class="checkbox">
                <label>
                  <input id="faculty-modal-admin" type="checkbox"> Admin
                </label>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button id="faculty-modal-close-button" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="faculty-modal-button" type="button" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>

 <script>

  var currentLetter = "a",
      facultyList = [];

  function init() {
    // add button event listener
    $("#faculty-add-button").click(addButtonClick);

    // hide table until we have data
    $("#faculty-table").css("display", "none");

    // request faculty list with last name starting with ...
    currentLetter = cislib.getURLParameter("l") || currentLetter;
    cislib.managerRequest("faculty", "getList", currentLetter, redrawTable);
  }

  function redrawTable(result) {

    // show notice and exit if there are no records
    if (result.length == 0) {
      $("#faculty-notice").html("There are no faculty records for last names starting with '" + currentLetter + "'.");
      return;
    }

    // store locally
    facultyList = result;

    // create faculty table
    var tableString = "";
    for (var i = 0; i < result.length; i++) {
      tableString += "<tr>";
      tableString += "<td>" + result[i]["f_studentId"] + "</td>";
      tableString += "<td>" + result[i]["f_lastName"] + "</td>";
      tableString += "<td>" + result[i]["f_firstName"] + "</td>";
      tableString += "<td>" + result[i]["f_phone"] + "</td>";
      tableString += "<td>" + result[i]["f_email"] + "</td>";

      tableString += "<td>";
      tableString += (result[i]["f_isAdmin"] == 1) ? "yes" : "no";
      tableString += "</td>";

      tableString += "<td><button id='faculty-edit-button-" + i + "' type='button' class='btn btn-warning btn-xs' data-toggle='modal' data-target='#faculty-modal'>edit</button></td>"
      tableString += "<td><button id='faculty-delete-button-" + i + "'type='button' class='btn btn-danger btn-xs'>delete</button></td>";
      tableString += "</tr>";
    }

    // add the table
    $("#faculty-table-body").html(tableString);
    $("#faculty-table").css("display", "block");

    // add event listeners
    for (var i = 0; i < result.length; i++) {
      $("#faculty-edit-button-" + i).click(editButtonClick);
      $("#faculty-delete-button-" + i).click(deleteButtonClick);
    }
  }

  function addButtonClick(event) {
    // make modal form blank
    $("#faculty-modal-student-num").val("");
    $("#faculty-modal-last-name").val("");
    $("#faculty-modal-first-name").val("");
    $("#faculty-modal-email").val("");
    $("#faculty-modal-phone").val("");
    $("#faculty-modal-admin").prop("checked", "");

    // set modal properties
    $("#faculty-modal-label").html("Add Faculty Record");
    $("#faculty-modal-button").html("Add");
    $("#faculty-modal-button").click(modalButtonClick);
    $("#faculty-modal-close-button").click(function() {
      $("#faculty-modal-button").unbind();
      $("#faculty-modal-close-button").unbind();
    });
  }

  function editButtonClick(event) {
    var index = event.target.id.substr(20),
        faculty = facultyList[index];
    $("#faculty-modal-student-num").val(faculty['f_studentId']);
    $("#faculty-modal-last-name").val(faculty['f_lastName']);
    $("#faculty-modal-first-name").val(faculty['f_firstName']);
    $("#faculty-modal-email").val(faculty['f_email']);
    $("#faculty-modal-phone").val(faculty['f_phone']);

    var checked = (faculty['f_isAdmin'] == 1) ? "checked" : "";
    $("#faculty-modal-admin").prop("checked", checked);

    // set modal properties
    $("#faculty-modal-label").html("Edit Faculty Record");
    $("#faculty-modal-button").html("Update");
    $("#faculty-modal-button").click(modalButtonClick);
    $("#faculty-modal-close-button").click(function() {
      $("#faculty-modal-button").unbind();
      $("#faculty-modal-close-button").unbind();
    });
  }

  function deleteButtonClick(event) {
    if (event.target.innerHTML == "delete") {
      event.target.innerHTML = "confirm";
    } else {
      var index = event.target.id.substr(22);
      var studentId = facultyList[index]['f_studentId'];
      cislib.managerRequest("faculty", "delete", studentId, function(result) {
        window.location.href = window.location.href;
      });
    }
  }

  function modalButtonClick(event) {
    var facultyObject = {
      studentId : $("#faculty-modal-student-num").val(),
      lastName  : $("#faculty-modal-last-name").val(),
      firstName : $("#faculty-modal-first-name").val(),
      lastName  : $("#faculty-modal-last-name").val(),
      email     : $("#faculty-modal-email").val(),
      phone     : $("#faculty-modal-phone").val(),
      isAdmin   : $("#faculty-modal-admin").prop("checked"),
    };

    var buttonName = $("#faculty-modal-button").html();
    switch (buttonName) {

      case "Add":
        currentLetter = facultyObject.lastName.substr(0, 1).toLowerCase();
        cislib.managerRequest("faculty", "add", facultyObject, function(result) {
          if (result)
            window.location.href = "?p=sett&t=facl&l=" + currentLetter;
          else
            window.location.href = "?p=sett&t=facl";
        });
        break;

      case "Update":
        cislib.managerRequest("faculty", "update", facultyObject, function(result) {
          window.location.href = window.location.href;
        });
        break;
    }
  }

  init();

</script>