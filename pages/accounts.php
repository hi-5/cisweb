<h1>System Accounts</h1>

<form id="account-form">
<!-- new row -->
<div class="row">
  <div class="col-md-2">
    <div class="btn-group-vertical" id="account-list">
      <!-- accounts will appear here -->
    </div>
  </div>

  <div class="col-md-10">
    <!-- new row -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="studentNumber">Account Name</label>
          <input name="name" class="form-control" id="account-name" placeholder="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="studentNumber">Profile</label>
          <select name="prof" class="form-control" id="account-profile"></select>
        </div>
      </div>
    </div>

    <!-- new row -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="studentNumber">Account Password</label>
          <input name="pass" class="form-control" id="account-password" placeholder="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="studentNumber">Status</label>
          <select name="stat" class="form-control" id="account-status">
            <option>enabled</option>
            <option>disabled</option>
          </select>
        </div>
      </div>
    </div>

    <!-- new row -->
    <div class="row">
      <div class="col-md-12" id="account-buttons">
        <!-- dynamic buttons will appear here -->
      </div>
    </div>

  </div>
</div>
</form>

<script>
  var profileNames = {},
      accountNames = [],
      buttons = [],
      newMode = true;

  // == new, update and delete dynamic buttons ==

  function removeButtons() {
    for ( var i = 0; i < buttons.length; i++ )
      $( '#' + buttons[i].id ).remove();
    buttons = [];
  }

  // style: default, primary, success, info, warning, danger, link
  function addButton( label, style, clickFnct ) {
    var newButton = document.createElement( 'button' );
        newButton.style.marginRight = '5px';
        newButton.className = 'btn btn-' + style;
        newButton.type = 'button';
        newButton.id = 'acct-bttn-' + style;
        newButton.innerHTML = label;
        newButton.onclick = clickFnct;
    buttons.push( newButton );
    $( '#account-buttons' ).append( newButton );
  }

  function newAccountClick() {
    var args = $('#account-form').serialize();
    manage( 'account', 'add', args, newAccountResponse );
  }

  function newAccountResponse( result ) {
    location.reload();
  }

  function updateAccountClick() {
    var args = $('#account-form').serialize();
    manage( 'account', 'update', args, updateAccountResponse );
  }

  function updateAccountResponse() {
    // add fading confirmation
  }

  function deleteAccountClick() {
    var acctName = $( '#account-name' ).val();
    manage( 'account', 'delete', { name:acctName }, deleteAccountResponse );
  }

  function deleteAccountResponse() {
    location.reload();
  }

  // == ajax & callbacks ==

  function manage( managerName, action, args, callback ) {
    $.ajax({
      type     : 'POST',
      url      : 'php/' + managerName + 'manager.php',
      dataType : 'json',
      data     : { action : action,
                   args   : args },
      cache    : false,
      success  : function( result ) {
        callback( result );
      },
      error    : function(a, b, c) {
        console.log('Error:');
        console.log(a);
        console.log(b);
        console.log(c);
      }
    });
  }

  function loadProfileNames( result ) {
    profileNames = result;

    var html = '';
    for ( var i = 0; i < result.length; i++ )
      html += '<option>' + result[i]['name'] + "</option>";
    $( '#account-profile' ).html( html );
  }

  function loadAccountNames( result ) {
    var html = '',
        index = 0;
    for (var key in result) {
      accountNames.push( result[key].name );
      html += '<div class="btn-group">';
      html += '<button type="button" id="account' + index + '" class="btn btn-default">';
      html += result[key].name;
      html += '</div>';
      index++;
    }
    $( '#account-list' ).html( html );

    // set listeners
    for ( var i = 0; i <= index; i++ ) {
      $( '#account' + i ).click(function ( e ) {
        var username = e.currentTarget.outerText;
        manage( 'account', 'get', { name:username }, loadAccount );
      });
    }
  }

  function loadAccount( result ) {
    // == name and password fields ==
    $( '#account-name' ).val( result['name'] );
    $( '#account-password' ).val( result['pass'] );

    // == profile field ==
    var profileBox = $( '#account-profile' )[0],
        myProfileId = result['prof'],
        myProfileName = '';

    // get profile name
    for ( var i = 0; i < profileNames.length; i++ ) {
      if ( profileNames[i]['id'] == myProfileId )
        myProfileName = profileNames[i]['name'];
    }

    // set profile field
    for ( var i = 0; i < profileBox.options.length; i++ ) {
      if ( profileBox.options[i].text == myProfileName )
        profileBox.selectedIndex = i;
    }

    // == status field ==
    var statusBox = $( '#account-status' )[0],
        isEnabled = result['enab'];
    if ( isEnabled == 1 )
      statusBox.selectedIndex = 0;
    else
      statusBox.selectedIndex = 1;

    // set buttons
    removeButtons();
    addButton( 'Update Account', 'success', updateAccountClick );
    addButton( 'Delete Account', 'danger', deleteAccountClick );
  }

  // == keyboard events ==

  function nameFieldChange( e ) {
    var nameField = e.target.value,
        nextMode = true;

    // see if the typed username matches any existing account names
    for ( var i = 0; i < accountNames.length; i++ )
      if ( accountNames[i] == nameField )
        nextMode = false;

    // add new buttons if the modes differ
    if ( newMode != nextMode ) {
      newMode = nextMode;
      removeButtons();
      if ( newMode ) {
        addButton( 'Create New', 'warning', newAccountClick );
      } else {
        addButton( 'Update Account', 'success', updateAccountClick );
        addButton( 'Delete Account', 'danger', deleteAccountClick );
      }
    }
  }

  // == init ==

  function init() {
    manage( 'account', 'list', {}, loadAccountNames );
    manage( 'profile', 'list', {}, loadProfileNames );
    addButton( 'Create New', 'warning', newAccountClick );
    $( '#account-name' ).keyup( nameFieldChange );
  }
  init();
  
</script>