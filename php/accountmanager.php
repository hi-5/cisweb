<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ( $action ) {

    // add an account
    case 'add':
      addAccount( $_POST['args'] );
      break;

    // delete an account
    case 'delete':
      deleteAccount( $_POST['args'] );
      break;

    // update an account
    case 'update':
      updateAccount( $_POST['args'] );
      break;

    // get list of account names
    case 'list':
      sendList();
      break;

    // get one accounts information
    case 'get':
      sendOne( $_POST['args']['name'] );
      break;
  }

  function addAccount( $args ) {
    global $sql;

    // get account details
    $args = explode( '&', $args );
    $name = $password = $profId = $status = null;
    for ( $i = 0; $i < count($args); $i++ ) {
      $tempArg = explode( '=', $args[$i] );
      if ( $tempArg[0] == 'name' )
        $name = $tempArg[1];
      else if ( $tempArg[0] == 'pass' )
        $password = $tempArg[1];
      else if ( $tempArg[0] == 'prof' )
        $profileName = $tempArg[1];
      else if ( $tempArg[0] == 'stat' )
        $status = $tempArg[1];
    }

    // get profileId based off profile name
    $query  = "SELECT p_id FROM profiles WHERE p_name = '$profileName'";
    $result = mysqli_query( $sql, $query );
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $profId = $row['p_id'];

    // set enabled as boolen
    $status = ( $status == 'enabled' ) ? 1 : 0;

    // store account
    $query  = "INSERT INTO accounts (a_enabled, a_profileId, a_username, a_password) VALUES ($status, $profId, '$name', '$password')";
    $result = mysqli_query( $sql, $query );

    echo $result;
  }

  function updateAccount( $args ) {
    global $sql;

    // get account details
    $args = explode( '&', $args );
    $name = $password = $profId = $status = null;
    for ( $i = 0; $i < count($args); $i++ ) {
      $tempArg = explode( '=', $args[$i] );
      if ( $tempArg[0] == 'name' )
        $name = $tempArg[1];
      else if ( $tempArg[0] == 'pass' )
        $password = $tempArg[1];
      else if ( $tempArg[0] == 'prof' )
        $profileName = $tempArg[1];
      else if ( $tempArg[0] == 'stat' )
        $status = $tempArg[1];
    }

    // get profileId based off profile name
    $query  = "SELECT p_id FROM profiles WHERE p_name = '$profileName'";
    $result = mysqli_query( $sql, $query );
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $profId = $row['p_id'];

    // set enabled as boolen
    $status = ( $status == 'enabled' ) ? 1 : 0;

    // update account
    $query  = "UPDATE accounts SET a_enabled=$status, a_profileId=$profId, a_password='$password' WHERE a_username = '$name'";
    $result = mysqli_query( $sql, $query );

    echo $result;
  }

  function deleteAccount( $args ) {
    global $sql;

    $name = $args['name'];
    $query  = "DELETE FROM accounts WHERE a_username = '$name'";
    $result = mysqli_query( $sql, $query );

    echo $result;
  }

  function sendList() {
    global $sql;

    $query  = "SELECT a_id, a_username FROM accounts";
    $result = mysqli_query( $sql, $query );

    $posts = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $posts[]  = array("id"   => $row['a_id'],
                        "name" => $row['a_username']);
    }
    echo json_encode( $posts );
  }

  function sendOne( $username ) {
    global $sql;

    $query  = "SELECT a_username, a_password, a_profileId, a_enabled FROM accounts WHERE a_username = '$username'";
    $result = mysqli_query( $sql, $query );
    $row    = mysqli_fetch_array( $result, MYSQLI_ASSOC );
    $posts  = array( "name" => $row['a_username'],
                     "pass" => $row['a_password'],
                     "prof" => $row['a_profileId'],
                     "enab" => $row['a_enabled'] );
    echo json_encode( $posts );
  }
?>