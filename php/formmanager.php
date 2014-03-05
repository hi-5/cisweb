<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ($action) {

    // submit registration form
    case 'register':
      register();
      break;

    // approve registration/verification form
    case 'approve':
      approve();
      break;

    // delete athlete form
    case 'delete':
      delete();
      break;
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

    // convert team history array into storable string
    $teamHistory = "";
    for ($i = 0; $i < count($_POST['args']['teamHist']); $i++) {
      $teamHistory = $teamHistory . 
                     $_POST['args']['teamHist'][$i]['startYear'] . ":" .
                     $_POST['args']['teamHist'][$i]['endYear'] . ":" .
                     $_POST['args']['teamHist'][$i]['teamId'] . ":" .
                     $_POST['args']['teamHist'][$i]['teamName'] . ":" .
                     $_POST['args']['teamHist'][$i]['position'] . ":" .
                     $_POST['args']['teamHist'][$i]['jersey'] . ":" .
                     $_POST['args']['teamHist'][$i]['charged'];
      if ($i < count($_POST['args']['teamHist']) - 1)
        $teamHistory = $teamHistory . "|";
    }

    $query = "INSERT INTO athletequeue VALUES ($studentId, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', 
              '$weight', '$email', '$highSchool', $gradYear, '$program', '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', 
              '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone', '$teamHistory')";
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

  
?>