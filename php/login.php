<?PHP

  session_start();
  include "connect.php";

  $username = $_POST["name"];
  $password = $_POST["pass"];

  $query  = "SELECT * FROM accounts WHERE a_username = '$username'";
  $result = mysqli_query( $sql, $query );

  // if username is in accounts table, it is a system account
  if ( mysqli_num_rows( $result ) > 0 ) {

    // verify password
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ( $password != $row['a_password'] )
      exit;

    // set permissions
    $profileId = $row['a_profileId'];
    $query = "SELECT * FROM profiles WHERE p_id = '$profileId'";
    $result = mysqli_query( $sql, $query );
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    foreach ($row as $key => $value) {
      if ($key == "p_id" || $key == "p_name") continue;
      $newKey = substr($key, 2);
      $_SESSION[$newKey] = $value;
    }
    
    // set authentication
    $_SESSION['username'] = $username;
    $_SESSION['isStudent'] = false;
    $_SESSION['loggedIn'] = true;
    header( 'Location: ../index.php?a=' . $_SESSION['loggedIn'] );

  // if username is not in accounts table, it might be a student account
  } else {

    // set authentication
    $_SESSION['username'] = $username;
    $_SESSION['isStudent'] = true;
    $_SESSION['loggedIn'] = true;
    header( 'Location: ../index.php' );

    // do shibboleth stuff here

  }
  header( 'Location: ../index.php' );
?>