<?php
  require_once("conn.php");
  $admin_flag = (bool)false;
  $bachelor_flag = (bool)false;
  $attendee_flag = (bool)false;
  $login_result = array();

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
      $admin_flag = (bool)true;
      $login_result['id'] = $check_admin_email_result[0]['adminId'];
      $login_result['email'] = $check_admin_email_result[0]['email'];
      $login_result['fullName'] = $check_admin_email_result[0]['fullName'];
    } else if ($check_bachelors_email_result && $check_bachelors_email_prepared_stmt->rowCount() > 0) {
      $bachelor_flag = (bool)true;
      $login_result['id'] = $check_bachelors_email_result[0]['bachelorId'];
      $login_result['email'] = $check_bachelors_email_result[0]['email'];
      $login_result['fullName'] = $check_bachelors_email_result[0]['fullName'];
      $login_result['class'] = $check_bachelors_email_result[0]['class'];
      $login_result['major'] = $check_bachelors_email_result[0]['major'];
      $login_result['biography'] = $check_bachelors_email_result[0]['biography'];
      $login_result['photoUrl'] = $check_bachelors_email_result[0]['photoUrl'];
      $login_result['maxBid'] = $check_bachelors_email_result[0]['maxBid'];
      $login_result['auctionStatus'] = $check_bachelors_email_result[0]['auctionStatus'];
      $login_result['addedBy'] = $check_bachelors_email_result[0]['addedBy'];
      $login_result['auction_order_id'] = $check_bachelors_email_result[0]['auction_order_id'];
    } else if ($check_attendees_email_result && $check_attendees_email_prepared_stmt->rowCount() > 0) {
      $attendee_flag = (bool)true;
      $login_result['id'] = $check_attendees_email_result[0]['attendeeId'];
      $login_result['email'] = $check_attendees_email_result[0]['email'];
      $login_result['fullName'] = $check_attendees_email_result[0]['fullName'];
      $login_result['accountBalance'] = $check_attendees_email_result[0]['accountBalance'];
      $login_result['totalDonations'] = $check_attendees_email_result[0]['totalDonations'];
      $login_result['auctionWon'] = $check_attendees_email_result[0]['auctionWon'];
    }
  }
 ?>
