<?php

require_once("conn.php");
require_once("createflags.php");

$bachelors = "SELECT * FROM aka.bachelors WHERE auctionStatus = 0 ORDER BY auction_order_id ASC";
$auctions = "SELECT * FROM aka.auctions";

try {
    $bachelors_prepared_stmt = $dbo->prepare($bachelors);
    $bachelors_prepared_stmt->execute();
    $bachelors_result = $bachelors_prepared_stmt->fetchAll();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
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
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body>

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
    </div>
    <?php
    if (!$admin_flag) {
      ?>
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
      <?php
    } else {
      ?>
      <br>
      <p>Before the event, please make sure that you have ordered all the bachelors
        on <a href="order-bachelors.php">this page</a>.</p>
      <?php
    }
     ?>


    <div class="event" id="event">
      <div class="bachelor">
        <table>
          <tr>
            <?php
            if ($bachelors_result && $bachelors_prepared_stmt->rowCount() > 0) {
              foreach ($bachelors_result as $header) {
                $bachelorFullName = $header['fullName'];
                $bachelorClass = $header['class'];
                $bachelorMajor = $header['major'];

                ?>
                <th>
                  <strong><?php echo $bachelorFullName; ?></strong><br>
                  <?php echo "Classification: " . $bachelorClass; ?>
                  <?php echo "Major: " . $bachelorMajor; ?>
                </th>
                <?php
              } ?>

          </tr>
          <tr>
            <?php
              foreach ($bachelors_result as $row) {
                $bachelorBiography = $header['biography'];
                $bachelorProfilePicture = $header['photoUrl'];
                $bachelorMaxBid = $header['maxBid'];
                $bachelorAuctionStatus = $header['auctionStatus'];
                $bachelorAddedBy = $header['addedBy'];
                ?>
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
                </td>
                    <?php
                  }
                   ?>
                </div>
                <?php
              }
             ?>
          </tr>
            <?php
          }
           ?>
        </table>
      </div>
      <?php
      if ($admin_flag) {
        ?>
        <div class="buttons">
          <!-- <form class="" action="auction.php" method="post">
            <input type="submit" name="skip_bachelor" value="Skip Next Bachelor">
          </form> -->
          <form class="" action="auction.php" method="post">
            <input type="submit" name="next_bachelor" value="Next Bachelor">
          </form>
        </div>
        <?php
      } else if ($attendee_flag) {
        ?>
        <div class="buttons">
          <form class="" action="index.html" method="post">
            <input type="number" name="bid" value="">
            <input type="submit" name="make_bid" value="Make Bid">
            <p><?php echo "AKA Dollars Available: $" . $login_result['accountBalance']; ?></p>
          </form>
        </div>
        <?php
      }
        ?>
    </div>
</div>

<?php include_once("overlay.php"); ?>

</div>


<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var account = document.getElementsByClassName("dropdown-btn-account");
    var i;
    var j;

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

    for (j = 0; j < account.length; j++) {
        account[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownAccount = this.nextElementSibling;
            if (dropdownAccount.style.display === "block") {
                dropdownAccount.style.display = "none";
            } else {
                dropdownAccount.style.display = "block";
            }
        });
    }
</script>
</body>
</html>
