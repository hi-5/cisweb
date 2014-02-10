<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ( $action ) {

    // add a profile
    case 'add':
      break;

    // delete a profile
    case 'delete':
      break;

    // update a profile
    case 'update':
      break;

    // get list of profile names
    case 'list':
      sendList();
      break;

    // get one profiles information
    case 'get':
      sendOne( $_POST['args']['name'] );
      break;
  }

  function sendList() {
    global $sql;

    $query  = "SELECT p_id, p_name FROM profiles";
    $result = mysqli_query( $sql, $query );

    $names = array();
    while ( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
      $names[]  = array( "id"   => $row['p_id'],
                         "name" => $row['p_name'] );
    }
    echo json_encode( $names );
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