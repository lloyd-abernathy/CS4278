<?php
require_once("conn.php");
if (isset($_COOKIE["eventDate"])) {
  print_r("cookie set ");
  $start_event = new DateTime();
  $start_event_int = intval($_COOKIE['eventDate']) * 1000;
  $start_event->setTimestamp(strval($start_event_int));
  $begins = (bool)($start_event < time());
  if ($begins) {
    print_r("beginning ");
    $bachelor = "SELECT * FROM aka.bachelors WHERE auctionStatus = 0, addedBy IS NOT NULL, auction_order_id != 0 ORDER BY auction_order_id ASC LIMIT 1";

    try {
        $bachelor_prepared_stmt = $dbo->prepare($bachelor);
        // $bachelor_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $bachelor_prepared_stmt->execute();
        $bachelor_result = $bachelor_prepared_stmt->fetchAll();
    } catch (PDOException $ex) { // Error in database processing.
        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }

    if (isset($bachelor_result) && $bachelor_prepared_stmt->rowCount() > 0) {
        $curr_bachelor = $bachelor_result[0];
        $bachelorID = $curr_bachelor['bachelorId'];

        // Check if auction exists for current bachelor
        $find_auction = "SELECT * FROM aka.auctions
                       WHERE bachelorId = :bachelorId";
        try {
            $find_auction_prepared_stmt = $dbo->prepare($find_auction);
            $find_auction_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
            $find_auction_prepared_stmt->execute();
            $find_auction_result = $find_auction_prepared_stmt->fetchAll();
        } catch (PDOException $ex) { // Error in database processing.
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

        // If auction doesn't exist, create one and set cookies for time interval
        if ($find_auction_prepared_stmt->rowCount() == 0) {
            // Add bachelor to auction table
            $auctions = "INSERT INTO aka.auctions (bachelorId, timeStart, timeComplete)
                     VALUES (:bachelorId, :currTime, :tenMinutesLater)";
            try {
                $auctions_prepared_stmt = $dbo->prepare($auctions);
                $auctions_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                $auctions_prepared_stmt->bindValue(':currTime', time(), PDO::PARAM_INT);
                $auctions_prepared_stmt->bindValue(':tenMinutesLater', time() + (60*10), PDO::PARAM_INT);
                $auctions_prepared_stmt->execute();
            } catch (PDOException $ex) { // Error in database processing.
                echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
            }
        }

        // Set cookies for time interval
        $time_cookies = "SELECT *
                      FROM aka.auctions
                      WHERE bachelorId = :bachelorId";
        try {
            $time_cookies_prepared_stmt = $dbo->prepare($time_cookies);
            $time_cookies_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
            $time_cookies_prepared_stmt->execute();
            $time_cookies_result = $time_cookies_prepared_stmt->fetchAll();
        } catch (PDOException $ex) { // Error in database processing.
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

        if (isset($time_cookies_result) && $time_cookies_prepared_stmt->rowCount() > 0) {
            $startTime = $time_cookies_result[0]['timeStart'];
            $endTime = $time_cookies_result[0]['timeComplete'];
            $auction_over = new DateTime();
            $auction_over->setTimestamp($endTime);
            $timestamp = $auction_over->getTimestamp() + 1;
            ?>
            <script type="text/javascript">
                var start_time = "<?php echo $startTime; ?>";
                var end_time = "<?php echo $endTime; ?>";
                createTimeCookies('startTime', start_time);
                createTimeCookies('endTime', end_time);

                function createTimeCookies(name, value) {
                    var expired = <?php echo $timestamp; ?>;
                    var date = new Date(expired * 1000);
                    var expires = "; expires=" + date.toGMTString();

                    document.cookie = name + "=" + value + expires + "; path=/;";
                }
            </script>
            <?php
        }
        $bachelorFullName = $curr_bachelor['fullName'];
        $bachelorClass = $curr_bachelor['class'];
        $bachelorMajor = $curr_bachelor['major'];
        $bachelorBiography = $curr_bachelor['biography'];
        $bachelorProfilePicture = $curr_bachelor['photoUrl'];
        $bachelorMaxBid = $curr_bachelor['maxBid'];
        $bachelorAuctionStatus = $curr_bachelor['auctionStatus'];
        $bachelorAddedBy = $curr_bachelor['addedBy'];
    }
  } else {
    print_r("waiting");
  }
}

 ?>
