<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

// Resets values in the bachelor, auction and bid tables for testing auction page
// $set_bachelors = "UPDATE aka.bachelors SET auctionStatus = 0, maxBid = 0";
// try {
//   $show_attendees_prepared_stmt = $dbo->prepare($set_bachelors);
//   $show_attendees_prepared_stmt->execute();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
//
// $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
// $truncate_attendees = "TRUNCATE TABLE aka.auctions";
// $truncate_bids = "TRUNCATE TABLE aka.bids";
// $foreign_checks_one = "SET FOREIGN_KEY_CHECKS = 1";
//
// try {
//   $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
//   $foreign_checks_zero_prepared_stmt->execute();
//
//   $truncate_attendees_prepared_stmt = $dbo->prepare($truncate_attendees);
//   $truncate_attendees_prepared_stmt->execute();
//
//   $truncate_bids_prepared_stmt = $dbo->prepare($truncate_bids);
//   $truncate_bids_prepared_stmt->execute();
//
//   $foreign_checks_one_prepared_stmt = $dbo->prepare($foreign_checks_one);
//   $foreign_checks_one_prepared_stmt->execute();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
//
//
//
// $show_auctions = "SELECT * FROM aka.auctions";
// $show_bids = "SELECT * FROM aka.bids";
// try {
//   $show_auctions_prepared_stmt = $dbo->prepare($show_auctions);
//   $show_auctions_prepared_stmt->execute();
//   $show_auctions_result = $show_auctions_prepared_stmt->fetchAll();
//   print_r($show_auctions_result);
//
//   $show_bids_prepared_stmt = $dbo->prepare($show_bids);
//   $show_bids_prepared_stmt->execute();
//   $show_bids_result = $show_bids_prepared_stmt->fetchAll();
//   print_r($show_bids_result);
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
// ?>
 <script type="text/javascript">
// function deleteCookie(name) {
//   document.cookie = name+ "=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/;";
// }
// deleteCookie('event');
// deleteCookie('startTime');
// deleteCookie('endTime');
// </script>
 <?php
// print_r($_COOKIE);
// $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
// $truncate_attendees = "DELETE FROM aka.bachelors WHERE email = :email";
// $foreign_checks_one = "SET FOREIGN_KEY_CHECKS = 1";
//
// try {
//   $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
//   $foreign_checks_zero_prepared_stmt->execute();
//
//   $truncate_attendees_prepared_stmt = $dbo->prepare($truncate_attendees);
//   $truncate_attendees_prepared_stmt->bindValue(':email', 'artisticinnovation99@gmail.com', PDO::PARAM_STR);
//   $truncate_attendees_prepared_stmt->execute();
//
//   $foreign_checks_one_prepared_stmt = $dbo->prepare($foreign_checks_one);
//   $foreign_checks_one_prepared_stmt->execute();
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }

// $show_bids = "SELECT * FROM aka.bachelors";
// try {
//   $show_bids_prepared_stmt = $dbo->prepare($show_bids);
//   $show_bids_prepared_stmt->execute();
//   $show_bids_result = $show_bids_prepared_stmt->fetchAll();
//   print_r($show_bids_result);
// } catch (PDOException $ex) {
//   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }
?>
