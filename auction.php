<?php

require_once("conn.php");
require_once("createflags.php");
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
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/auction.js"></script>
</head>
<body>

<?php include_once("header.php"); ?>

<div class="auction_info">
    <h2>Countdown to HeartbreAKA</h2>
    <div id="about_heartbreaka" class="about_heartbreaka"
         style="height:200px;margin-bottom:10px;">
         <br>
        <p>In accordance with our current initiatives, the Elegant Eta Beta Chapter
            of Alpha Kappa Alpha Sorority Inc. hosts HeartbreAKA every year to raise
            money and collect art supplies for the Mary Parrish Center. HeartbreAKA
            is a date auction where attendees bid on the eligible bachelors being
            presented to win a complimentary group date with the chapter. <br><br>
            <strong>So, how does the event happen?</strong> <br>
            Prior to the event, attendees can make physical and monetary donations using this website. Upon receiving the
            donation, the correct amount of AKA dollars will be awarded to the attendee
            to use in the auction. During the event, bachelors will be presented
            and attendees will decide if they want to place a bid for that bachelor.
            The attendee with the highest bid will win the date and will receive
            further instructions later about where and when the date will be held.<br>
            Overall, HeartbreAKA is meant to be a fun event where you can make
            a significant contribution to the community.</p>
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

    <div class="start_event" id="start_event">
      <?php
      if ($admin_flag) {
        ?>
        <form id="admin_button" class="buttons" action="live-auction.php" method="post">
          <input class="start_event" type="submit" name="start_event" value="Start Event">
        </form>
        <?php
      } else {
        ?>
        <form  class="buttons" action="please-wait.php" method="post">
          <input id="attendee_button" class="start_event" type="submit" name="go_to_event" value="Go To Event">
        </form>
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
