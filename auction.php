<?php

require_once("conn.php");
require_once("createflags.php");

// Set sql mode
$sql_mode = "SET sql_mode=''";
try {
    $sql_mode_prepared_stmt = $dbo->prepare($sql_mode);
    $sql_mode_prepared_stmt->execute();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

// Load one bachelor at a time
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
         $auctions_prepared_stmt->bindValue(':tenMinutesLater', time() +  60, PDO::PARAM_INT);
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

       if ($time_cookies_result && $time_cookies_prepared_stmt->rowCount() > 0) {
         $startTime = $time_cookies_result[0]['timeStart'];
         $endTime = $time_cookies_result[0]['timeComplete'];
         $auction_over = new DateTime();
         $auction_over->setTimestamp($endTime);
         $timestamp = $auction_over->getTimestamp() + 60;
         ?>
         <script type="text/javascript">
         var start_time = "<?php echo $startTime; ?>";
         var end_time = "<?php echo $endTime; ?>";
         createTimeCookies('startTime', start_time);
         createTimeCookies('endTime', end_time);
         function createTimeCookies(name, value) {
           var expired = <?php echo $timestamp; ?>;
           var date = new Date(expired * 1000);
           var expires = "; expires="+date.toGMTString();

           document.cookie = name+ "=" + value+expires+"; path=/;";
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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>HeartbreAKA Auction</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/auction.css">
    <script type="text/javascript" src="js/auction.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script src="/js/get-max-bid.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body onload="setInterval('get-max-bid.js', 10000)">

<?php include_once("header.php"); ?>

<div class="auction_info">
    <h2>HeartbreAKA Auction</h2>
    <div id="about_heartbreaka" class="about_heartbreaka" style="height:200px;margin-bottom:10px;margin-left:20px;">
        <p>In accordance with our current initiatives, the Elegant Eta Beta Chapter
            of Alpha Kappa Alpha Sorority Inc. hosts HeartbreAKA every year to raise
            money for an important cause. HeartbreAKA is a date auction where
            attendees bid on the eligible bachelors being presented to win a
            complimentary group date with the chapter. <br>
            So, how does the event happen? Prior to the event, attendees can make
            physical and monetary donations using this website. Upon receiving the
            donation, the correct amount of AKA dollars will be awarded to the attendee
            to use in the auction. During the event, bachelors will be presented
            and attendees will decide if they want to place a bid for that bachelor.
            The attendee with the highest bid will win the date and will receive
            further instructions later about where and when the date will be held.<br>
            Overall, HeartbreAKA is meant to be a fun event where you can make
            a significant contribution to the community.</p>
            <?php
            if ($admin_flag) {
              ?>
              <br>
              <p >Before the event, please make sure that you have ordered all the bachelors
                on <a href="order-bachelors.php">this page</a>.</p>
              <?php
            }
             ?>
    </div>

      <div class="countdown" id="countdown">
          <div class="days">
              <p class="num" id="num_day"></p>
              <p class="label" id="label_day">days</p>
          </div>
          <div class="hours">
              <p class="num" id="num_hr"></p>
              <p class="label" id="label_hr">hours</p>
          </div>
          <div class="minutes">
              <p class="num" id="num_min"></p>
              <p class="label" id="label_min">minutes</p>
          </div>
          <div class="seconds">
              <p class="num" id="num_sec"></p>
              <p class="label" id="label_sec">seconds</p>
          </div>
      </div>

    <div class="event" id="event">
      <div class="bachelor" id="bachelor">
        <script type="text/javascript" src="js/auction-timer.js"></script>
        <?php
        if ($bachelor_result && $bachelor_prepared_stmt->rowCount() > 0) {
         ?>
        <table>
          <tr>
            <th>
              <strong><?php echo $bachelorFullName; ?></strong><br>
              <?php echo "Classification: " . $bachelorClass; ?><br>
              <?php echo "Major: " . $bachelorMajor; ?>
            </th>
          </tr>
          <tr>
            <td>
              <div class="bachelor_img">
                <img src="<?php echo $bachelorProfilePicture; ?>" alt="">
              </div>
              <div class="bachelor_info">
                <?php
                $bachelorBiographyArr = explode("||", $bachelorBiography);
                foreach ($bachelorBiographyArr as $str) {
                  $question = explode("=", $str);
                  ?>
                  <strong><?php echo $question[0]; ?></strong><br><br>
                  <p><?php echo substr($question[1], 1, -1); ?></p><br>
                  <?php
                }
                 ?>
                 <div class="timer">
                   <span id="timer"></span>
                 </div>
                 <div class="current_bid">
                   <!-- Current Bid goes here -->
                   Current Bid: <span id="bid"></span>
                 </div>
              </div>
            </td>
          </tr>
        </table>
          <?php
        } else {
          ?>
          <p>No more bachelors to present! Thank you for coming to our HeartbreAKA event!</p>
          <form class="" action="index.php" method="post">
            <input class="quick_links" type="submit" name="go_home" value="Go to Homepage">
          </form>
          <?php
          if ($admin_flag) {
            ?>
           <form class="" action="view_winners.php" method="post">
             <input class="quick_links" type="submit" name="view_winners" value="View Winners">
           </form>
           <?php
          }
        }
       ?>
     </div>

      <?php
      if ($admin_flag) {
        ?>
        <div class="buttons">
          <!-- <form class="" action="auction.php" method="post">
            <input type="submit" name="skip_bachelor" value="Skip Next Bachelor">
          </form> -->
          <!-- <form class="" action="auction.php" method="post">
            <input type="submit" name="next_bachelor" value="Next Bachelor">
          </form> -->
        </div>
        <?php
      } else if ($attendee_flag) {
        ?>
        <form class="make_bid" action="index.html" method="post">
          <input type="number" name="bid" value="0" min="0">
          <input type="submit" name="make_bid" value="Make Bid">
          <p><?php echo "AKA Dollars Available: $" . $login_result['accountBalance']; ?></p>
          <input type="hidden" name="attendee_id" value="<?php $login_result['id']; ?>">
        </form>
        <?php
      }
        ?>
    </div>
</div>

<?php
// Update Auction table with bid
if (isset($_POST['make_bid'])) {
  $attendee_id = $_POST['attendee_id'];
  $bid = $_POST['bid'];
  // IDEA: This may be the logic needed to update the current bid as well
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
  } catch (PDOException $ex) { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
  }

  if ($get_max_bid_result && $get_max_bid_prepared_stmt->rowCount() == 1) {
    $maxBid = $get_max_bid_result[0]['maxBid'];
    if ($bid > $maxBid) {
      $add_bid = "INSERT INTO aka.bids (attendeeId, bachelorId, bidAmount)
                  VALUES (:attendeeId, :bachelorId, :bid)";

      try {
          $add_bid_prepared_stmt = $dbo->prepare($add_bid);
          $add_bid_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
          $add_bid_prepared_stmt->bindValue(':bachelorId', $attendee_id, PDO::PARAM_INT);
          $add_bid_prepared_stmt->bindValue(':bachelorId', $bid, PDO::PARAM_INT);
          $add_bid_prepared_stmt->execute();
      } catch (PDOException $ex) { // Error in database processing.
          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
      }
    }
  }

}

$time_expired = new DateTime();
$time_expired->setTimestamp($_COOKIE['endTime']);
$expired = (bool)(($time_expired->getTimestamp() - time()) < 0);
// Reload page for next bachelor
if (null !== $_COOKIE['timer'] && $expired) {
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
   $get_max_bid_end_auction = "SELECT bidId,
                                      attendeeId,
                                      MAX(bidAmount) AS maxBid
                               FROM aka.bids
                               WHERE bachelorId = :bachelorId
                               GROUP BY bachelorId";
   try {
       $get_max_bid_end_auction_prepared_stmt = $dbo->prepare($get_max_bid_end_auction);
       $get_max_bid_end_auction_prepared_stmt->bindValue(':bachelorId', $bachelorID, PDO::PARAM_INT);
       $get_max_bid_end_auction_prepared_stmt->execute();
       $get_max_bid_end_auction_result = $get_max_bid_end_auction_prepared_stmt->fetchAll();
   } catch (PDOException $ex) { // Error in database processing.
       echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
   }

   if ($get_max_bid_end_auction_result && $get_max_bid_end_auction_prepared_stmt->rowCount() == 1) {
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
          $update_auction_table_prepared_stmt->bindValue(':bidId', $winningBidId, PDO::PARAM_INT);
          $update_auction_table_prepared_stmt->execute();
      } catch (PDOException $ex) { // Error in database processing.
          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
      }
   }
}
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
</body>
</html>
