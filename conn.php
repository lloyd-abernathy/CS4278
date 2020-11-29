<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);



// $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
// $truncate_attendees = "TRUNCATE TABLE aka.notifications";
// $foreign_checks_one = "SET FOREIGN_KEY_CHECKS = 1";
//
// try {
//   $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
//   $foreign_checks_zero_prepared_stmt->execute();
//   $foreign_checks_zero_result = $foreign_checks_zero_prepared_stmt->fetchAll();
//
//   $truncate_attendees_prepared_stmt = $dbo->prepare($truncate_attendees);
//   $truncate_attendees_prepared_stmt->execute();
//   $truncate_attendees_result = $truncate_attendees_prepared_stmt->fetchAll();
//
//   $foreign_checks_one_prepared_stmt = $dbo->prepare($foreign_checks_one);
//   $foreign_checks_one_prepared_stmt->execute();
//   $foreign_checks_one_result = $foreign_checks_one_prepared_stmt->fetchAll();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
//
// $show_attendees = "SELECT * FROM aka.notifications";
// try {
//   $show_attendees_prepared_stmt = $dbo->prepare($show_attendees);
//   $show_attendees_prepared_stmt->execute();
//   $show_attendees_result = $show_attendees_prepared_stmt->fetchAll();
//   print_r($show_attendees_result);
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }

// try {
//   $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
// } catch (PDOException $e) {
//   echo 'Connection failed: ' . $e->getMessage();
//   exit;
// }
//
// if ($dbo->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
?>
