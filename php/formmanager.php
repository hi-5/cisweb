<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ($action) {

    // add team to history
    case "addTeam":
      addTeam();
      break;

    // remove team from history
    case "removeTeam":
      removeTeam();
      break;

    // update team in history
    case "updateTeam":
      break;

    // submit registration form
    case "register":
      register();
      break;

    // approve registration/verification form
    case "approve":
      approve();
      break;

    // delete athlete form
    case "delete":
      delete();
      break;

    // get single athlete record
    case "getAthlete":
      getAthlete();
      break;
  }

  function addTeam() {
    global $sql;

    // !!! Need to add security measure to make sure students can only add teams to
    // !!! queue history table, and not the athletes table
    $queue = (mysqli_real_escape_string($sql, $_POST['args']['queue']) == "yes") ? true : false;
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $year = mysqli_real_escape_string($sql, $_POST['args']['year']);
    $teamId = mysqli_real_escape_string($sql, $_POST['args']['teamId']);
    $teamName = mysqli_real_escape_string($sql, $_POST['args']['teamName']);
    $position = mysqli_real_escape_string($sql, $_POST['args']['position']);
    $jersey = mysqli_real_escape_string($sql, $_POST['args']['jersey']);
    $charged = (mysqli_real_escape_string($sql, $_POST['args']['charged']) == "yes") ? 1 : 0;

    if ($queue)
      $query = "INSERT INTO athletequeuehistory (aqh_studentId, aqh_teamId, aqh_teamName, aqh_year, aqh_position, aqh_jerseyNumber, aqh_charged) VALUES ($studentId, $teamId, '$teamName', $year, '$position', $jersey, $charged)";
    else
      $query = "INSERT INTO athletehistory (ah_studentId, ah_teamId, ah_teamName, ah_year, ah_position, ah_jerseyNumber, ah_charged) VALUES ($studentId, $teamId, '$teamName', $year, '$position', $jersey, $charged)";
    $result = mysqli_query($sql, $query);

    echo json_encode($_POST['args']);
  }

  function removeTeam() {
    global $sql;

    // !!! Need to add security measure to make sure students can only add/remove 
    // !!! teams to/from queue history table, and not the athletes table
    $queue = (mysqli_real_escape_string($sql, $_POST['args']['queue']) == "yes") ? true : false;
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $year = mysqli_real_escape_string($sql, $_POST['args']['year']);

    if ($queue)
      $query = "DELETE FROM athletequeuehistory WHERE aqh_studentId = $studentId AND aqh_year = $year";
    else
      $query = "DELETE FROM athletehistory WHERE ah_studentId = $studentId AND ah_year = $year";
    $result = mysqli_query($sql, $query);

    echo json_encode($_POST['args']);
  }

  function register() {
    global $sql;

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $lastName = mysqli_real_escape_string($sql, $_POST['args']['lastName']);
    $firstName = mysqli_real_escape_string($sql, $_POST['args']['firstName']);
    $initials = mysqli_real_escape_string($sql, $_POST['args']['initials']);
    $gender = mysqli_real_escape_string($sql, $_POST['args']['gender']);
    $dob = mysqli_real_escape_string($sql, $_POST['args']['dob']);
    $height = mysqli_real_escape_string($sql, $_POST['args']['height']);
    $weight = mysqli_real_escape_string($sql, $_POST['args']['weight']);
    $email = mysqli_real_escape_string($sql, $_POST['args']['email']);
    $highSchool = mysqli_real_escape_string($sql, $_POST['args']['highSchool']);
    $gradYear = mysqli_real_escape_string($sql, $_POST['args']['gradYear']);
    $program = mysqli_real_escape_string($sql, $_POST['args']['program']);

    $cStreet = mysqli_real_escape_string($sql, $_POST['args']['cStreet']);
    $cCity = mysqli_real_escape_string($sql, $_POST['args']['cCity']);
    $cProvince = mysqli_real_escape_string($sql, $_POST['args']['cProvince']);
    $cPostal = mysqli_real_escape_string($sql, $_POST['args']['cPostal']);
    $cCountry = mysqli_real_escape_string($sql, $_POST['args']['cCountry']);
    $cPhone = mysqli_real_escape_string($sql, $_POST['args']['cPhone']);

    $pStreet = mysqli_real_escape_string($sql, $_POST['args']['pStreet']);
    $pCity = mysqli_real_escape_string($sql, $_POST['args']['pCity']);
    $pProvince = mysqli_real_escape_string($sql, $_POST['args']['pProvince']);
    $pPostal = mysqli_real_escape_string($sql, $_POST['args']['pPostal']);
    $pCountry = mysqli_real_escape_string($sql, $_POST['args']['pCountry']);
    $pPhone = mysqli_real_escape_string($sql, $_POST['args']['pPhone']);

    $query = "INSERT INTO athletequeue VALUES ($studentId, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', 
              '$weight', '$email', '$highSchool', $gradYear, '$program', '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', 
              '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone')";
    $result = mysqli_query($sql, $query);

    echo $result;
  }

  function approve() {
    global $sql;

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['studentId']);
    $lastName = mysqli_real_escape_string($sql, $_POST['args']['lastName']);
    $firstName = mysqli_real_escape_string($sql, $_POST['args']['firstName']);
    $initials = mysqli_real_escape_string($sql, $_POST['args']['initials']);
    $gender = mysqli_real_escape_string($sql, $_POST['args']['gender']);
    $dob = mysqli_real_escape_string($sql, $_POST['args']['dob']);
    $height = mysqli_real_escape_string($sql, $_POST['args']['height']);
    $weight = mysqli_real_escape_string($sql, $_POST['args']['weight']);
    $email = mysqli_real_escape_string($sql, $_POST['args']['email']);
    $highSchool = mysqli_real_escape_string($sql, $_POST['args']['highSchool']);
    $gradYear = mysqli_real_escape_string($sql, $_POST['args']['gradYear']);
    $program = mysqli_real_escape_string($sql, $_POST['args']['program']);

    $cStreet = mysqli_real_escape_string($sql, $_POST['args']['cStreet']);
    $cCity = mysqli_real_escape_string($sql, $_POST['args']['cCity']);
    $cProvince = mysqli_real_escape_string($sql, $_POST['args']['cProvince']);
    $cPostal = mysqli_real_escape_string($sql, $_POST['args']['cPostal']);
    $cCountry = mysqli_real_escape_string($sql, $_POST['args']['cCountry']);
    $cPhone = mysqli_real_escape_string($sql, $_POST['args']['cPhone']);

    $pStreet = mysqli_real_escape_string($sql, $_POST['args']['pStreet']);
    $pCity = mysqli_real_escape_string($sql, $_POST['args']['pCity']);
    $pProvince = mysqli_real_escape_string($sql, $_POST['args']['pProvince']);
    $pPostal = mysqli_real_escape_string($sql, $_POST['args']['pPostal']);
    $pCountry = mysqli_real_escape_string($sql, $_POST['args']['pCountry']);
    $pPhone = mysqli_real_escape_string($sql, $_POST['args']['pPhone']);

    // create athlete record
    $query = "INSERT INTO athletes VALUES ($studentId, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', 
              '$weight', '$email', '$highSchool', $gradYear, '$program', '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', 
              '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone')";
    $result = mysqli_query($sql, $query);

    // create athlete history records
    for ($i = 0; $i < count($_POST['args']['teamHist']); $i++) {
      $year = mysqli_real_escape_string($sql, $_POST['args']['teamHist'][$i]['startYear']);
      $teamId = mysqli_real_escape_string($sql, $_POST['args']['teamHist'][$i]['teamId']);
      $teamName = mysqli_real_escape_string($sql, $_POST['args']['teamHist'][$i]['teamName']);
      $position = mysqli_real_escape_string($sql, $_POST['args']['teamHist'][$i]['position']);
      $jersey = mysqli_real_escape_string($sql, $_POST['args']['teamHist'][$i]['jersey']);
      $charged = ($_POST['args']['teamHist'][$i]['charged'] == "yes") ? 1 : 0;
      $query = "INSERT INTO athletehistory (ah_studentId, ah_teamId, ah_teamName, ah_year, ah_position, ah_jerseyNumber, ah_charged) 
                VALUES ($studentId, $teamId, '$teamName', $year, '$position', $jersey, $charged)";
      $result = mysqli_query($sql, $query);
    }

    // delete record from queue
    $query = "DELETE FROM athletequeue WHERE aq_studentId = $studentId";
    $result = mysqli_query($sql, $query);
    
    echo 1;
  }

  function delete() {
    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "DELETE FROM athletequeue WHERE aq_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result;
  }

  function getAthlete() {
    global $sql;
    
    // get query information
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['id']);
    $queue = ($_POST['args']['queue'] == "yes") ? true : false;

    // get athlete information
    $info = array();
    if ($queue)
      $query = "SELECT * FROM athletequeue WHERE aq_studentId = '$studentId'";
    else
      $query = "SELECT * FROM athletes WHERE a_studentId = '$studentId'";
    $result = mysqli_query($sql, $query);
    $row = mysqli_fetch_assoc($result);
    $info[] = $row;
    
    // get athlete history
    $history = array();
    if ($queue)
      $query = "SELECT * FROM athletequeuehistory WHERE aqh_studentId = '$studentId'";
    else
      $query = "SELECT * FROM athletehistory WHERE ah_studentId = '$studentId'";
    $result = mysqli_query($sql, $query);
    while ($row = mysqli_fetch_assoc($result))
      $history[] = $row;

    // send client merged array
    echo json_encode(array_merge($info, $history));         
  }

?>