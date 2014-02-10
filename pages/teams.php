<h1>Teams</h1>

<!-- new row -->
<div class="row">
  <div class="col-md-2">
    <div class="btn-group-vertical" id="faculty-list">
    </div>
  </div>

  <div class="col-md-10">
    <!-- new row -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="studentNumber">Account Name</label>
          <input type="email" class="form-control" id="studentNumber" placeholder="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="studentNumber">Profile</label>
          <select class="form-control">
            <option>admin</option>
            <option>coach</option>
            <option>doctor</option>
            <option>student</option>
          </select>
        </div>
      </div>
    </div>

    <!-- new row -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="studentNumber">Account Password</label>
          <input type="email" class="form-control" id="studentNumber" placeholder="">
        </div>
      </div>
    </div>

    <!-- new row -->
    <div class="row">
      <div class="col-md-2">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
      </div>
    </div>

  </div>
</div>

<script>
  $.ajax({
      type     : 'POST',
      url      : 'php/getaccounts.php',
      dataType : 'json',
      data     : {},
      cache    : false,
      success  : function( result ) {
        var html = '';
        for (var key in result) {
          html += '<div class="btn-group">';
          html += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">';
          html += result[key].name + ' ';
          html += '<span class="caret"></span>';
          html += '</button>';
          html += '<ul class="dropdown-menu">';
          html += '<li><a href="#">Modify</a></li>';
          html += '<li><a href="#">Delete</a></li>';
          html += '</ul>';
          html += '</div>';
        }
        $( '#account-list' ).html( html );
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
</script>