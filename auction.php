<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HeartbreAKA Auction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/auction.css">
    <script type="text/javascript" src="js/auction.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
  </head>
  <body>

    <div id="info">
      <div class="header">
        <div class="header_left">
          <span onclick="openNav()"><i class="fa fa-ellipsis-v"></i></span>
        </div>

        <div class="header_center">
          <h1>Alpha Kappa Alpha Sorority, Inc.</h1>
          <h1>Elegant Eta Beta Chapter</h1>
        </div>

        <div class="header_right">
        </div>
      </div>

      <div class="auction_info">
        <h2>HeartbreAKA Auction</h2>
        <div class="about_heartbreaka" style="height:200px;margin-bottom:10px;margin-left:20px;">
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
          <div class="admin_event" id="admin_event">

          </div>
          <div class="bachelors_event" id="bachelors_event">

          </div>
          <div class="attendees_event" id="attendees_event">

          </div>
        </div>
      </div>


      <div id="myNav" class="overlay">

      <!-- Button to close the overlay navigation -->
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

      <!-- Overlay content -->
      <div class="overlay-content">
        <a href="login.html" class="login" id="sign-up">Sign Up | Login</a>
        <!-- Default for Logout button is hidden-- only show when user logged in-->
        <button id="account-btn" class="dropdown-btn-account" style="display:none">Account
          </button>
        <div class="dropdown-container-account">
          <a href="account.php" id="account">View Profile</a>
          <a href="index.html" id="sign-out" onclick="signOut();">Logout</a><br><br>
        </div>
        <a href="index.html">Home</a>
        <a href="about-chapter.html">About Elegant Eta Beta</a>
        <button class="dropdown-btn-donations">Make Donations <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container-donations">
          <a href="donations-money.php">Monetary Donations</a>
          <a href="donations-dropbox.php">Dropbox Donations</a>
        </div>
        <a href="bachelors.php">Bachelors</a>
        <a href="auction.php">HeartbreAKA Auction</a>
      </div>

    </div>



    <script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var account = document.getElementsByClassName("dropdown-btn-account");
    var i;
    var j;

    for (i = 0; i < donations.length; i++) {
      donations[i].addEventListener("click", function() {
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
      account[i].addEventListener("click", function() {
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
