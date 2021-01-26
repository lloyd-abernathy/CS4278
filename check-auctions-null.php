<?php
require_once("conn.php");

$auctions = "SELECT * FROM aka.auctions";

try {
    $auctions_prepared_stmt = $dbo->prepare($auctions);
    $auctions_prepared_stmt->execute();
    $auctions_result = $auctions_prepared_stmt->fetchAll();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

if ($auctions_result == null) {
  print_r("true");
} else {
  print_r("false");
}
 ?>
