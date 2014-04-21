<?PHP

/*
  - This file is used in AJAX calls from the pages.
  - It contains a switch statement used to call various functions
  - for displaying inbox data for administrators.
  -
  - File: inboxmanager.php
  - Author: Chris Wright
  - Last updated: 2014/04/21
  - Last updated by: Mike P.
*/

  include "connect.php";
  include "cislib.php";

  session_start();
  loggedAdmin();

  $action = $_POST['action'];
  switch ( $action ) {

    // get number of forms in queue
    case 'getAmount':
      getAmount();
      break;

    // get inbox
    case 'retrieve':
      retrieveInbox();
      break;
  }

  //Gets the number of entries waiting in the queues
  function getAmount() {
    global $sql;

    $query = "SELECT COUNT(*) FROM athletequeue";
    $result = mysqli_query($sql, $query);
    $row = mysqli_fetch_row($result);

    echo $row[0];
  }

  //Gets a list of the entries waiting in the queues
  function retrieveInbox() {
    global $sql;

    // select all records sitting in queue
    $query = "SELECT aq_studentId, aq_lastName, aq_firstName FROM athletequeue";
    $result = mysqli_query( $sql, $query );

    $inbox = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

      // check if there is a permanent student record
      $studentId = $row['aq_studentId'];

      $teamQuery = "SELECT aqh_teamName FROM athletequeuehistory WHERE aqh_studentId = $studentId ORDER BY aqh_year DESC LIMIT 1";
      $teamResult = mysqli_query($sql, $teamQuery);
      $teamRow = mysqli_fetch_row($teamResult);
      $team = $teamRow[0];

      $inbox[]  = array("id"    => $row['aq_studentId'],
                        "last"  => $row['aq_lastName'],
                        "first" => $row['aq_firstName'],
                        "team"  => $team);
    }
    echo json_encode( $inbox );
  }

?>