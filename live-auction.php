<?php

require_once("conn.php");
require_once("createflags.php");

// Set sql mode
$sql_mode = "SET sql_mode=''";
$foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
try {
    $sql_mode_prepared_stmt = $dbo->prepare($sql_mode);
    $sql_mode_prepared_stmt->execute();
    $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
    $foreign_checks_zero_prepared_stmt->execute();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

// Load one bachelor at a time
$bachelor = "SELECT * FROM aka.bachelors
             WHERE auctionStatus = 0 AND addedBy IS NOT NULL AND auction_order_id != 0
             ORDER BY auction_order_id ASC LIMIT 1";

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
        if ($admin_flag) {
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
        } else {
          sleep(5);
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

// Reload page for next bachelor
if (isset($bachelorID)) {
    if (isset($_COOKIE["timer-" . $bachelorID])) {
        $time_expired = new DateTime();
        $end_time_int = intval($_COOKIE['endTime']) * 1000;
        $time_expired->setTimestamp(strval($end_time_int));
        $expired = (bool)($time_expired < time());
        if ($expired) {
            $update_bachelor_auction_status = "UPDATE aka.bachelors
                                         SET auctionStatus = 1
                                         WHERE bachelorId = :bachelorId";
            try {
                $update_bachelor_auction_status_prepared_stmt = $dbo->prepare($update_bachelor_auction_status);
                $update_bachelor_auction_status_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                $update_bachelor_auction_status_prepared_stmt->execute();
            } catch (PDOException $ex) { // Error in database processing.
                echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
            }
            // Get maximum bid from bids table
            $get_max_bid_end_auction = "SELECT bachelorId,
                                            bidId,
                                            attendeeId,
                                            MAX(bidAmount) AS maxBid
                                     FROM aka.bids
                                     WHERE bachelorId = :bachelorId
                                     GROUP BY bachelorId
                                     ORDER BY MAX(bidAmount) ASC";
            try {
                $get_max_bid_end_auction_prepared_stmt = $dbo->prepare($get_max_bid_end_auction);
                $get_max_bid_end_auction_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                $get_max_bid_end_auction_prepared_stmt->execute();
                $get_max_bid_end_auction_result = $get_max_bid_end_auction_prepared_stmt->fetchAll();
            } catch (PDOException $ex) { // Error in database processing.
                echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
            }

            if ($get_max_bid_end_auction_prepared_stmt->rowCount() > 0) {
                $bidId = $get_max_bid_end_auction_result[0]['bidId'];
                $bid_attendeeId = $get_max_bid_end_auction_result[0]['attendeeId'];
                $bid_maxBid = $get_max_bid_end_auction_result[0]['maxBid'];
                $update_auction_table = "UPDATE aka.auctions
                                    SET winningAttendeeId = :attendeeId, winningBidId = :bidId, winningBid = :maxBid
                                    WHERE bachelorId = :bachelorId";
                // Update auction table
                try {
                    $update_auction_table_prepared_stmt = $dbo->prepare($update_auction_table);
                    $update_auction_table_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                    $update_auction_table_prepared_stmt->bindValue(':attendeeId', $bid_attendeeId, PDO::PARAM_INT);
                    $update_auction_table_prepared_stmt->bindValue(':maxBid', $bid_maxBid, PDO::PARAM_INT);
                    $update_auction_table_prepared_stmt->bindValue(':bidId', $bidId, PDO::PARAM_INT);
                    $update_auction_table_prepared_stmt->execute();
                } catch (PDOException $ex) { // Error in database processing.
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
                $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
                $update_attendee_table = "UPDATE aka.attendees
                                     SET auctionWon = 1, accountBalance = accountBalance - :maxBid
                                     WHERE attendeeId = :attendeeId";
                // Update attendees table
                try {
                    $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
                    $foreign_checks_zero_prepared_stmt->execute();

                    $update_attendee_table_prepared_stmt = $dbo->prepare($update_attendee_table);
                    $update_attendee_table_prepared_stmt->bindValue(':attendeeId', $bid_attendeeId, PDO::PARAM_INT);
                    $update_attendee_table_prepared_stmt->bindValue(':maxBid', $bid_maxBid, PDO::PARAM_INT);
                    $update_attendee_table_prepared_stmt->execute();
                } catch (PDOException $ex) { // Error in database processing.
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }

                $update_bachelors_table = "UPDATE aka.bachelors
                                     SET maxBid = :maxBid
                                     WHERE bachelorId = :bachelorId";
                // Update bachelors table
                try {

                    $update_bachelors_table_prepared_stmt = $dbo->prepare($update_bachelors_table);
                    $update_bachelors_table_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                    $update_bachelors_table_prepared_stmt->bindValue(':maxBid', $bid_maxBid, PDO::PARAM_INT);
                    $update_bachelors_table_prepared_stmt->execute();
                } catch (PDOException $ex) { // Error in database processing.
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>HeartbreAKA Auction</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/live-auction.css">
    <script src="js/live-auction.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body>

<?php include_once("header.php"); ?>

<div class="auction_info">
    <h2>HeartbreAKA Auction LIVE</h2><br>
    <div class="event" id="event">
        <div class="bachelor" id="bachelor">
            <script type="text/javascript">
                function getCookie(cname) {
                  var name = cname + "=";
                  var decodedCookie = decodeURIComponent(document.cookie);
                  var ca = decodedCookie.split(';');
                  for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                      c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                      return c.substring(name.length, c.length);
                    }
                  }
                  return "";
                }
                function createTimerCookie(name, value) {
                    var date = new Date();
                    date.setTime(date.getTime() + (5 * 1000));
                    var expires = "; expires=" + date.toGMTString();

                    document.cookie = name + "=" + value + expires + "; path=/;";
                }
                var endAuction = new Date(parseInt(getCookie("endTime")) * 1000);
                var id = "<?php echo $bachelorID; ?>";
                var timerName = "timer-" + id.toString();
                var auctionInterval = setInterval(function () {
                    var auctionTime = new Date();
                    // console.log(auctionTime);
                    // console.log(endAuction);

                    var untilAuctionOver = endAuction - auctionTime;

                    var auctionMinutes = Math.floor((untilAuctionOver % (1000 * 60 * 60)) / (1000 * 60));
                    var auctionSeconds = Math.floor((untilAuctionOver % (1000 * 60)) / 1000);
                    var min = auctionMinutes.toString();
                    var sec = auctionSeconds.toString();

                    if (auctionMinutes < 10) {
                        min = "0" + auctionMinutes.toString();
                    }
                    if (auctionSeconds < 10) {
                        sec = "0" + auctionSeconds.toString();
                    }

                    if (untilAuctionOver >= 0) {
                        document.getElementById('timer').innerHTML = min + ":" + sec;
                    } else {
                        clearInterval(auctionInterval);
                        document.getElementById('timer').innerHTML = "AUCTION CLOSED";
                        createTimerCookie(timerName, "expired");
                        location.reload();
                    }
                }, 1000);
            </script>
            <?php
            // Update Auction table with bid
            if (isset($_POST['make_bid'])) {
                $isSuccess = (bool)false;
                $highest = (bool)false;
                $attendee_id = $login_result['id'];
                $bid = $_POST['bid'];

                $add_bid_new = "INSERT INTO aka.bids (attendeeId, bachelorId, bidAmount)
                              VALUES (:attendeeId, :bachelorId, :bid)";

                try {


                    $add_bid_new_prepared_stmt = $dbo->prepare($add_bid_new);
                    $add_bid_new_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
                    $add_bid_new_prepared_stmt->bindValue(':attendeeId', $attendee_id, PDO::PARAM_INT);
                    $add_bid_new_prepared_stmt->bindValue(':bid', $bid, PDO::PARAM_INT);
                    $add_bid_new_prepared_stmt->execute();
                    $isSuccess = (bool)true;
                } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
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
                    // if ($get_max_bid_prepared_stmt->rowCount() > 0) {
                    //     print_r("$" . $get_max_bid_result[0]['maxBid']);
                    // }

                } catch (PDOException $ex) { // Error in database processing.
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }

                if ($get_max_bid_prepared_stmt->rowCount() > 0) {
                  if ($get_max_bid_result[0]['maxBid'] < $bid) {
                    $highest = (bool)true;
                  }
                } else {
                  $highest = (bool)true;
                }

                if ($isSuccess && $highest) {
                    ?>
                    <h6 class="form_submission_successful">You successfully
                      submitted the highest bid!
                    </h6><br>
                    <?php
                }  else if ($isSuccess && !$highest) {
                  ?>
                  <h6 class="form_submission_successful">Your bid was submitted successfully! However,
                    your bid is not the highest!
                  </h6><br>
                  <?php
                } else {
                    ?>
                    <h6 class="form_submission_error">Your bid did not submit! Please
                        notify us in the chat window!</h6><br>
                    <?php
                }
            }

            if (isset($bachelor_result) && $bachelor_prepared_stmt->rowCount() > 0) {
                ?>
                <div class="bachelors_auction">
                  <div class="bachelor_img">
                    <img src="<?php echo $bachelorProfilePicture; ?>" alt="">
                  </div>
                  <div class="curr_bid">
                    <div class="timer">
                        <span id="timer">00:00</span>
                        <div class="current_bid">
                            <!-- Current Bid goes here -->
                            <script type="text/javascript">
                                var getMaxBid = setInterval(
                                    function () {

                                        var xhttp;
                                        xhttp = new XMLHttpRequest();
                                        xhttp.open("GET", "get-max-bid.php", true)
                                        xhttp.send();
                                        xhttp.onreadystatechange = function () {
                                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                                document.getElementById("bid").innerHTML = xhttp.responseText;
                                            }
                                        }
                                    }, 1000);
                            </script>
                            CURRENT BID: <span id="bid"></span>
                        </div>
                    </div>
                    <div class="name">
                      <strong><?php echo $bachelorFullName; ?></strong><br>
                      <?php echo "Classification: " . $bachelorClass; ?><br>
                      <?php echo "Major: " . $bachelorMajor; ?>
                    </div>
                  </div>
                  <?php
                  if ($attendee_flag && $vanderbilt_flag) {
                      ?>
                      <form class="make_bid" action="live-auction.php" method="post">
                          <input type="number" name="bid" value="0" min="0">
                          <input type="submit" name="make_bid" value="Make Bid">
                          <p><?php echo "AKA Dollars Available: $" . $login_result['accountBalance']; ?></p>
                      </form>
                      <?php

                  }
                  ?>
                  <div class="bachelor_bio">
                    <div class="biography">
                          <?php
                          $bachelorBiographyArr = explode("||", $bachelorBiography);
                          foreach ($bachelorBiographyArr as $str) {
                          $question = explode("=", $str);
                          ?>
                          <p id="question" style="text-align: center;"><strong><?php echo $question[0]; ?></strong></p>
                          <p style="text-align: center;"><?php echo substr($question[1], 1, -1); ?></p><br>
                        <?php
                        }
                        ?>
                    </div>
                  </div>

                </div>

                <?php
            } else {
                ?>
                <p>No more bachelors to present! Thank you for coming to our HeartbreAKA event!</p>
                <form class="" action="index.html" method="post">
                    <input class="quick_links" type="submit" name="go_home" value="Go to Homepage">
                </form>
                <?php
                if ($admin_flag) {
                    ?>
                    <form class="" action="view-winners.php" method="post">
                        <input class="quick_links" type="submit" name="view_winners"
                               value="View Winners">
                    </form>
                    <?php
                }
            }
            ?>
        </div>

        <?php
        if ($admin_flag) {
            ?>
            <!-- <div class="buttons">
              <form class="" action="live-auction.php" method="post">
                <input type="submit" name="skip_bachelor" value="Skip Next Bachelor">
              </form>
              <form class="" action="live-auction.php" method="post">
                <input type="submit" name="next_bachelor" value="Next Bachelor">
              </form>
            </div> -->
            <?php
        } ?>
    </div>
</div>

<?php


// $foreign_checks_one = "SET FOREIGN_KEY_CHECKS = 1";
//
// try {
//   $foreign_checks_one_prepared_stmt = $dbo->prepare($foreign_checks_one);
//   $foreign_checks_one_prepared_stmt->execute();
// } catch (PDOException $ex) {
// echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
// }

include_once("overlay.php"); ?>

</div>
<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var i;

    for (i = 0; i < donations.length; i++) {
        donations[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownDonations = this.nextElementSibling;
            if (dropdownDonations.style.display === "block") {
                dropdownDonations.style.display = "none";
            } else {
                dropdownDonations.style.display = "block";
            }
        });
    }
</script>
<script type="text/javascript" src="js/cookies-enable.js"></script>

</body>
</html>
