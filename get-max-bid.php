<?php
require_once("conn.php");
$bachelor = "SELECT * FROM aka.bachelors WHERE auctionStatus = 0 ORDER BY auction_order_id ASC LIMIT 1";

try {
    $bachelor_prepared_stmt = $dbo->prepare($bachelor);
    // $bachelor_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $bachelor_prepared_stmt->execute();
    $bachelor_result = $bachelor_prepared_stmt->fetchAll();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
if ($bachelor_result && $bachelor_prepared_stmt->rowCount() > 0) {
  $bachelor_maxBid_ID = $bachelor_result[0]['bachelorId'];
}
$get_max_bid = "SELECT bachelorId,
                         MAX(bidAmount) AS maxBid
                  FROM aka.bids
                  WHERE bachelorId = :bachelorId
                  GROUP BY bachelorId";
  try {
      $get_max_bid_prepared_stmt = $dbo->prepare($get_max_bid);
      $get_max_bid_prepared_stmt->bindValue(':bachelorId', $bachelor_maxBid_ID, PDO::PARAM_INT);
      $get_max_bid_prepared_stmt->execute();
      $get_max_bid_result = $get_max_bid_prepared_stmt->fetchAll();
      if ($get_max_bid_prepared_stmt->rowCount() > 0) {
        print_r("$" . $get_max_bid_result[0]['maxBid']);
      } else {
        print_r("$0");
      }
  } catch (PDOException $ex) { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
 ?>
