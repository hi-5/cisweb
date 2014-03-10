<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ($action) {
    // get single athlete record from queue
    case 'getQueue':
      getQueue();
      break;
    // get single athlete record from athletes
    case 'getAthlete':
      getAthlete();
      break;
  }

  function getQueue() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "SELECT * FROM athletequeue WHERE aq_studentId = '$studentId'";
    $result = mysqli_query($sql, $query);
    $row = mysqli_fetch_assoc($result);

    $info = array("id"     => $row['aq_studentId'],
                  "last"   => $row['aq_lastName'],
                  "first"  => $row['aq_firstName'],
                  "init"   => $row['aq_initials'],
                  "gender" => $row['aq_gender'],
                  "dob"    => $row['aq_dob'],
                  "height" => $row['aq_height'],
                  "weight" => $row['aq_weight'],
                  "email"  => $row['aq_email'],
                  "high"   => $row['aq_highSchool'],
                  "grad"   => $row['aq_gradYear'],
                  "prog"   => $row['aq_program'],

                  "cStrt"  => $row['aq_cStreet'],
                  "cCity"  => $row['aq_cCity'],
                  "cProv"  => $row['aq_cProvince'],
                  "cCntr"  => $row['aq_cCountry'],
                  "cPost"  => $row['aq_cPostalCode'],
                  "cPhone" => $row['aq_cPhone'],

                  "pStrt"  => $row['aq_pStreet'],
                  "pCity"  => $row['aq_pCity'],
                  "pProv"  => $row['aq_pProvince'],
                  "pCntr"  => $row['aq_pCountry'],
                  "pPost"  => $row['aq_pPostalCode'],
                  "pPhone" => $row['aq_pPhone'],

                  "teams"  => $row['aq_teams']);

    echo json_encode( $info );   
  }

  function getAthlete() {

  }
  
?>