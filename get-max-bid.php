$get_max_bid = "SELECT bachelorId,
                         MAX(bidAmount) AS maxBid
                  FROM aka.bids
                  WHERE bachelorId = :bachelorId
                  GROUP BY bachelorId";
  try {
      $get_max_bid_prepared_stmt = $dbo->prepare($get_max_bid);
      $get_max_bid_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
      $get_max_bid_prepared_stmt->execute();
      $get_max_bid_result = $get_max_bid_prepared_stmt->fetchAll();
      echo $get_max_bid_result
  } catch (PDOException $ex) { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }
