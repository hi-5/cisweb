<?PHP
  include "connect.php";

  session_start();

  //Prevents unauthenticated AJAX posting
  if (!$_SESSION['loggedIn']) {
    die();
  }

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

    // update athlete
    case "update":
      update();
      break;

    // get single athlete record
    case "getAthlete":
      getAthlete();
      break;
  }

  function addTeam() { 
    global $sql;

    $queue = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['queue']) == "yes") ? true : false;
    $studentId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['studentId']));
    $institute = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['institute']));
    $year = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['year']));
    $teamId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['teamId']));
    $teamName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['teamName']));
    $position = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['position']));
    $jersey = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['jersey']));
    $charged = (mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['charged'])) == "yes") ? 1 : 0;

    if ($queue)
      $query = "INSERT INTO athletequeuehistory (aqh_studentId, aqh_institute, aqh_teamId, aqh_teamName, aqh_year, aqh_position, aqh_jerseyNumber, aqh_charged) VALUES ($studentId, '$institute', $teamId, '$teamName', $year, '$position', $jersey, $charged)";
    else if ($_SESSION['isAdmin'])
      $query = "INSERT INTO athletehistory (ah_studentId, ah_institute, ah_teamId, ah_teamName, ah_year, ah_position, ah_jerseyNumber, ah_charged) VALUES ($studentId, '$institute', $teamId, '$teamName', $year, '$position', $jersey, $charged)";
    else die();
    $result = mysqli_query($sql, $query);

    echo json_encode($_POST['args']);
  }

  function removeTeam() {
    global $sql;

    $queue = (mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['queue'])) == "yes") ? true : false;
    $studentId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['studentId']));
    $year = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['year']));

    if ($queue)
      $query = "DELETE FROM athletequeuehistory WHERE aqh_studentId = $studentId AND aqh_year = $year";
    else if ($_SESSION['isAdmin'])
      $query = "DELETE FROM athletehistory WHERE ah_studentId = $studentId AND ah_year = $year";
    $result = mysqli_query($sql, $query);

    echo json_encode($_POST['args']);
  }

  function register() {
    global $sql;

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['studentId']));
    $resident = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['resident']));
    $lastName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['lastName']));
    $firstName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['firstName']));
    $initials = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['initials']));
    $gender = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gender']));
    $dob = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['dob']));
    $height = mysqli_real_escape_string($sql, $_POST['args']['height']);
    $weight = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['weight']));
    $email = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['email']));
    $hometown = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['hometown']));
    $highSchool = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['highSchool']));
    $gradYear = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gradYear']));
    $program = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['program']));
    $yearOfStudy = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['yearOfStudy']));

    $cStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cStreet']));
    $cCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCity']));
    $cProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cProvince']));
    $cPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPostal']));
    $cCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCountry']));
    $cPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPhone']));

    $pStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pStreet']));
    $pCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCity']));
    $pProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pProvince']));
    $pPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPostal']));
    $pCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCountry']));
    $pPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPhone']));

    $query = "INSERT INTO athletequeue VALUES ($studentId, $resident, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', 
              '$weight', '$email', '$hometown', '$highSchool', $gradYear, '$program', $yearOfStudy, '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', 
              '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone')";
    $result = mysqli_query($sql, $query);

    echo $result;
  }

  function approve() {
    global $sql;

    //Security check
    if (!$_SESSION['isAdmin']) die();

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['studentId']));
    $resident = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['resident']));
    $lastName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['lastName']));
    $firstName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['firstName']));
    $initials = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['initials']));
    $gender = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gender']));
    $dob = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['dob']));
    $height = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['height']));
    $weight = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['weight']));
    $email = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['email']));
    $hometown = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['hometown']));
    $highSchool = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['highSchool']));
    $gradYear = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gradYear']));
    $program = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['program']));
    $yearOfStudy = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['yearOfStudy']));

    $cStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cStreet']));
    $cCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCity']));
    $cProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cProvince']));
    $cPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPostal']));
    $cCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCountry']));
    $cPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPhone']));

    $pStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pStreet']));
    $pCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCity']));
    $pProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pProvince']));
    $pPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPostal']));
    $pCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCountry']));
    $pPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPhone']));

    // create athlete record
    $query = "INSERT INTO athletes VALUES ($studentId, $resident, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', 
              '$weight', '$email', '$hometown', '$highSchool', $gradYear, '$program', $yearOfStudy, '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', 
              '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone');";
    $result = mysqli_query($sql, $query);

    // create athlete history records
    $query = "INSERT INTO athletehistory (ah_studentId, ah_institute, ah_teamId, ah_teamName, ah_year, ah_position, ah_jerseyNumber, ah_charged) SELECT aqh_studentId, aqh_institute, aqh_teamId, aqh_teamName, aqh_year, aqh_position, aqh_jerseyNumber, aqh_charged FROM athletequeuehistory WHERE aqh_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    // delete athlete record from queue
    $query = "DELETE FROM athletequeue WHERE aq_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    // delete athlete record history from queue
    $query = "DELETE FROM athletequeuehistory WHERE aqh_studentId = $studentId";
    $result = mysqli_query($sql, $query);
    
    echo $result;
  }

  function delete() {

    //Security check
    if (!$_SESSION['isAdmin']) die();

    global $sql;

    $studentId = mysqli_real_escape_string($sql, $_POST['args']);
    $query = "DELETE FROM athletequeue WHERE aq_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    $query = "DELETE FROM athletequeuehistory WHERE aqh_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result;
  }

  function update() {
    global $sql;

    //Security check
    if (!$_SESSION['isAdmin']) die();

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['studentId']));
    $resident = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['resident']));
    $lastName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['lastName']));
    $firstName = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['firstName']));
    $initials = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['initials']));
    $gender = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gender']));
    $dob = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['dob']));
    $height = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['height']));
    $weight = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['weight']));
    $email = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['email']));
    $hometown = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['hometown']));
    $highSchool = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['highSchool']));
    $gradYear = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['gradYear']));
    $program = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['program']));
    $yearOfStudy = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['yearOfStudy']));

    $cStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cStreet']));
    $cCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCity']));
    $cProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cProvince']));
    $cPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPostal']));
    $cCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cCountry']));
    $cPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['cPhone']));

    $pStreet = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pStreet']));
    $pCity = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCity']));
    $pProvince = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pProvince']));
    $pPostal = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPostal']));
    $pCountry = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pCountry']));
    $pPhone = mysqli_real_escape_string($sql, htmlspecialchars($_POST['args']['pPhone']));

    $query = "UPDATE athletes SET a_resident = $resident, a_lastName = '$lastName', a_firstName = '$firstName', a_initials = '$initials', 
              a_gender = '$gender', a_dob = '$dob', a_height = '$height', a_weight = '$weight', a_email = '$email', 
              a_hometown = '$hometown', a_highSchool = '$highSchool', a_gradYear = '$gradYear', a_program = '$program', a_yearOfStudy = $yearOfStudy, 
              a_cStreet = '$cStreet', a_cCity = '$cCity', a_cProvince = '$cProvince', a_cPostalCode = '$cPostal', a_cCountry = '$cCountry',
              a_cPhone = '$cPhone', a_pStreet = '$pStreet', a_pCity = '$pCity', a_pProvince = '$pProvince', 
              a_pPostalCode = '$pPostal', a_pCountry = '$pCountry', a_pPhone = '$pPhone' WHERE a_studentId = $studentId";
    $result = mysqli_query($sql, $query);

    echo $result;
  }

  function getAthlete() {
    global $sql;

    // get query information
    $studentId = mysqli_real_escape_string($sql, $_POST['args']['id']);
    $queue = ($_POST['args']['queue'] == "yes") ? true : false;

    //Security check
    if (!$_SESSION['isAdmin'] && $_SESSION['studentId'] != $studentId) die();

    // get athlete information
    $info = array(($queue) ? "aq_" : "a_");
    if ($queue)
      $query = "SELECT * FROM athletequeue WHERE aq_studentId = '$studentId'";
    else
      $query = "SELECT * FROM athletes WHERE a_studentId = '$studentId'";
    $result = mysqli_query($sql, $query);
    $row = mysqli_fetch_assoc($result);
    $info[] = $row;
    
    // get athlete history
    $history = array(($queue) ? "aqh_" : "ah_");
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