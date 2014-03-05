<?PHP
  include "connect.php";

  $action = $_POST['action'];
  switch ($action) {

    // submit registration form
    case 'register':
      register();
      break;
  }

  function register() {
    global $sql;

    // get form information from post
    $studentId = mysqli_real_escape_string($sql, $_POST['studentId']);
    $lastName = mysqli_real_escape_string($sql, $_POST['lastName']);
    $firstName = mysqli_real_escape_string($sql, $_POST['firstName']);
    $initials = mysqli_real_escape_string($sql, $_POST['initials']);
    $gender = mysqli_real_escape_string($sql, $_POST['gender']);
    $dob = mysqli_real_escape_string($sql, $_POST['dob']);
    $height = mysqli_real_escape_string($sql, $_POST['height']);
    $weight = mysqli_real_escape_string($sql, $_POST['weight']);
    $email = mysqli_real_escape_string($sql, $_POST['email']);
    $highSchool = mysqli_real_escape_string($sql, $_POST['highSchool']);
    $gradYear = mysqli_real_escape_string($sql, $_POST['gradYear']);
    $program = mysqli_real_escape_string($sql, $_POST['program']);

    $cStreet = mysqli_real_escape_string($sql, $_POST['cStreet']);
    $cCity = mysqli_real_escape_string($sql, $_POST['cCity']);
    $cProvince = mysqli_real_escape_string($sql, $_POST['cProvince']);
    $cPostal = mysqli_real_escape_string($sql, $_POST['cPostal']);
    $cCountry = mysqli_real_escape_string($sql, $_POST['cCountry']);
    $cPhone = mysqli_real_escape_string($sql, $_POST['cPhone']);

    $pStreet = mysqli_real_escape_string($sql, $_POST['pStreet']);
    $pCity = mysqli_real_escape_string($sql, $_POST['pCity']);
    $pProvince = mysqli_real_escape_string($sql, $_POST['pProvince']);
    $pPostal = mysqli_real_escape_string($sql, $_POST['pPostal']);
    $pCountry = mysqli_real_escape_string($sql, $_POST['pCountry']);
    $pPhone = mysqli_real_escape_string($sql, $_POST['pPhone']);

    // convert team history array into storable string
    $teamHistory = "";
    for ($i = 0; $i < count($_POST['teamHist']); $i++) {
      $teamHistory = $teamHistory . 
                     $_POST['teamHist'][$i]['startYear'] . ":" .
                     $_POST['teamHist'][$i]['endYear'] . ":" .
                     $_POST['teamHist'][$i]['teamId'] . ":" .
                     $_POST['teamHist'][$i]['teamName'] . ":" .
                     $_POST['teamHist'][$i]['position'] . ":" .
                     $_POST['teamHist'][$i]['jersey'] . ":" .
                     $_POST['teamHist'][$i]['charged'];
      if ($i < count($_POST['teamHist']) - 1)
        $teamHistory = $teamHistory . "|";
    }

    $query = "INSERT INTO athletequeue VALUES ($studentId, '$lastName', '$firstName', '$initials', '$gender', '$dob', '$height', '$weight', '$email', '$highSchool', $gradYear, '$program', '$cStreet', '$cCity', '$cProvince', '$cPostal', '$cCountry', '$cPhone', '$pStreet', '$pCity', '$pProvince', '$pPostal', '$pCountry', '$pPhone', '$teamHistory')";
    $result = mysqli_query( $sql, $query );

    echo $result;
  }

  
?>