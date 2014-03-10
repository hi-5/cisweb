<?PHP
  include "connect.php";

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

  function getAmount() {
    global $sql;

    $query = "SELECT COUNT(*) FROM athletequeue";
    $result = mysqli_query($sql, $query);
    $row = mysqli_fetch_row($result);

    echo $row[0];
  }

  function retrieveInbox() {
    global $sql;

    // select all records sitting in queue
    $query = "SELECT aq_studentId, aq_lastName, aq_firstName FROM athletequeue";
    $result = mysqli_query( $sql, $query );

    $inbox = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

      // check if there is a permanent student record
      $studentId = $row['aq_studentId'];
      $typeQuery = "SELECT COUNT(*) AS NumberOfRows FROM athletes WHERE a_studentId = $studentId";
      $typeResult = mysqli_query($sql, $typeQuery);
      $typeRow = mysqli_fetch_row($typeResult);
      $type = ($typeRow[0] == 1) ? "Verification" : "Registration";

      $inbox[]  = array("id"    => $row['aq_studentId'],
                        "last"  => $row['aq_lastName'],
                        "first" => $row['aq_firstName'],
                        "type"  => $type);
    }
    echo json_encode( $inbox );
  }

?>