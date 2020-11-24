<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>About Elegant Eta Beta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/about-chapter.css">
    <script type="text/javascript" src="js/about-chapter.js"></script>
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
        <a href="bachelors.html">Bachelors</a>
        <a href="auction.html">HeartbreAKA Auction</a>
      </div>

    </div>

    <div class="chapter_info" contenteditable="false">
      <h2>About Elegant Eta Beta</h2><br>
      <p>The Elegant Eta Beta Chapter of Alpha Kappa Alpha Sorority, Inc.
        was chartered on November 11, 1972 by a group of 13 sophisticated young
        women from Vanderbilt University and George Peabody College for Teachers.
        The establishment of our chapter by these dynamic women, made Alpha Kappa
        Alpha Sorority, Inc. the first black Greek letter sorority at Vanderbilt
        University. Eta Beta has continued to strive to bring Alpha Kappa Alpha’s
        purpose of sisterhood, scholarship, and supreme service to all mankind to
        fruition. Eta Beta has earned the award for Exemplary Undergraduate
        Chapter in the Southeastern Region for Alpha Kappa Alpha for innovative
        and informative programming on campus. Annually the chapter hosts several
        signature events including our Chicken and Waffles, Breast Cancer
        Awareness Talk, Phinancial Literacy, HeartbreAKA, Pink Goes Red, and Taste
        of AKA. You can stay up to date with the chapter by following them on Instagram
        <a href="https://www.instagram.com/elegantetabeta/">@elegantetabeta</a>.</p>
        <ul>
          <li><strong>Nickname:</strong> AKA</li>
          <li><strong>Founded:</strong> January 15, 1908</li>
          <li><strong>Charter Day:</strong> Eta Beta, November 11, 1972</li>
          <li><strong>Flower:</strong> Tea Rose</li>
          <li><strong>Colors:</strong> Salmon Pink and Apple Green</li>
          <li><strong>Signature Events:</strong> Chicken & Waffles, HeartbreAKA,
            Taste of AKA</li>
          <li><strong>National Website:</strong> <a href="http://www.aka.1908.com/">
            http://www.aka.1908.com/</a></li>
          <li><strong>Current President:</strong> Jadah Keith</li>
        </ul><br><br>
        <h2>Signature Events</h2><br>
        <div class="event_rows">
          <div class="column_left">
            <p><strong>Taste of AKA</strong></p>
            <p>Taste of AKA is one of our spring signature events. For the event,
              we bring multiple food trucks from local businesses to campus for
              students and faculty to enjoy their food for FREE! During the event,
              we also are raising money for the charity of our choice that hits
              one of our International targets.</p>
          </div>
          <div class="column_middle">
            <p><strong>Chicken & Waffles</strong></p>
            <p>Chicken & Waffles is a back-to-school event, co-hosted with the
              Kappa Theta Chapter of Alpha Phi Alpha Fraternity, Inc. At the event,
              we provide fried chicken, waffles, fruits, and drinks for students
              to come and enjoy! You also get the chance to interact with other
              students on campus while playing games and listening to music.</p>
          </div>
          <div class="column_right">
            <p><strong>Breast Cancer Awareness Talk</strong></p>
            <p>October is Breast Cancer Awareness Month and every year, the
              Elegant Eta Beta Chapter will host a speaker to talk about breast
              cancer and how it affects the Black community. Throughout the month,
              we continue to spread the message on our Instagram page.</p>
          </div>
        </div>
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
