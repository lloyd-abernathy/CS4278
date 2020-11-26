<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

try {
  $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  exit;
}

if ($dbo->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$admin_flag = (bool)false;
$bachelor_flag = (bool)false;
$attendee_flag = (bool)false;
$login_result;

function checkDatabaseStatus() {
  try {
    $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
  }
  if(isset($_COOKIE["email"]) && isset($_COOKIE["fullName"])) {
    $full_name = $_COOKIE["fullName"];
    $email = $_COOKIE["email"];

    $check_attendees_email = "SELECT * FROM aka.attendees WHERE email = :email";
    $check_admin_email = "SELECT * FROM aka.admins WHERE email = :email";
    $check_bachelors_email = "SELECT * FROM aka.bachelors WHERE email = :email";

    try {
        $check_attendees_email_prepared_stmt = $dbo->prepare($check_attendees_email);
        $check_attendees_email_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $check_attendees_email_prepared_stmt->execute();
        $check_attendees_email_result = $check_attendees_email_prepared_stmt->fetchAll();

        $check_admin_email_prepared_stmt = $dbo->prepare($check_admin_email);
        $check_admin_email_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $check_admin_email_prepared_stmt->execute();
        $check_admin_email_result = $check_admin_email_prepared_stmt->fetchAll();

        $check_bachelors_email_prepared_stmt = $dbo->prepare($check_bachelors_email);
        $check_bachelors_email_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $check_bachelors_email_prepared_stmt->execute();
        $check_bachelors_email_result = $check_bachelors_email_prepared_stmt->fetchAll();

    } catch (PDOException $ex) { // Error in database processing.
        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }

    if ($check_admin_email_result && $check_admin_email_prepared_stmt->rowCount() > 0) {
      $admin_flag = true;
      $login_result = array(
        'id' => $check_admin_email_result['adminId'],
        'email' => $check_admin_email_result['email'],
        'fullName' => $check_admin_email_result['fullName']
      );
    } else if ($check_bachelors_email_result && $check_bachelors_email_prepared_stmt->rowCount() > 0) {
      $bachelor_flag = true;
      $login_result = array(
        'id' => $check_bachelors_email_result['bachelorId'],
        'email' => $check_bachelors_email_result['email'],
        'fullName' => $check_bachelors_email_result['fullName'],
        'class' => $check_bachelors_email_result['class'],
        'major' => $check_bachelors_email_result['major'],
        'biography' => $check_bachelors_email_result['biography'],
        'photoUrl' => $check_bachelors_email_result['photoUrl'],
        'maxBid' => $check_bachelors_email_result['maxBid'],
        'auctionStatus' => $check_bachelors_email_result['auctionStatus'],
        'addedBy' => $check_bachelors_email_result['addedBy'],
        'auction_order_id' => $check_bachelors_email_result['auction_order_id']
      );
    } else if ($check_attendees_email_result && $check_attendees_email_prepared_stmt->rowCount() > 0) {
      $attendee_flag = true;
      $login_result = array(
        'id' => $check_attendees_email_result['attendeeId'],
        'email' => $check_attendees_email_result['email'],
        'fullName' => $check_attendees_email_result['fullName'],
        'accountBalance' => $check_attendees_email_result['accountBalance'],
        'totalDonations' => $check_attendees_email_result['totalDonations'],
        'auctionWon' => $check_attendees_email_result['auctionWon']
      );
    }

    return $attendee_flag || $admin_flag || $bachelor_flag;
  }
}
?>
