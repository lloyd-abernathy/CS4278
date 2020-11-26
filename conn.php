<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
$admin_flag = false;
$bachelor_flag = false;
$attendee_flag = false;
$result;

function checkDatabaseStatus() {
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

    if ($check_attendees_email_result && $check_attendees_email_prepared_stmt->rowCount() > 0) {
      $attendee_flag = true;
      $result = $check_attendees_email_result;
    } else if ($check_admin_email_result && $check_admin_email_prepared_stmt->rowCount() > 0) {
      $admin_flag = true;
      $result = $check_admin_email_result;
    } else if ($check_bachelors_email_result && $check_bachelors_email_prepared_stmt->rowCount() > 0) {
      $bachelor_flag = true;
      $result = $check_bachelors_email_result;
    }

    return $attendee_flag || $admin_flag || $bachelor_flag;
  }
}
?>
