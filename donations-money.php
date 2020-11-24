<?php

$dbhost = ' ';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Monetary Donations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/donations-money.css">
    <link rel="stylesheet" href="css/payment.css">
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
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

    <div class="monetary_donations_attendee">
      <h2>Make a Monetary Donation</h2><br><br>
      <form class="monetary_donations_form" action="" method="post" name="monetary" onsubmit="submitForm()">
        <label for="name">Name</label>
        <input type="text" name="name" required><br><br>

        <label for="email">Email Address</label>
        <input type="email" name="email" required><br><br>

        <label for="amount">Dollar Amount   $ </label>
        <input id="dollar_amount" type="number" name="amount" onchange="updateAKADollars()" min="1" required>
        <p id="aka_dollars">AKA Dollars Amount: </p><br>

        <label for="service">What payment service would you like to use?</label><br>
        <input type="radio" id="paypal" name="service" value="Paypal" disabled>
        <label for="paypal">PayPal</label><br>
        <input type="radio" id="cashapp" name="service" value="Cash App" checked>
        <label for="cashapp">Cash App</label><br>
        <input type="radio" id="venmo" name="service" value="Venmo">
        <label for="venmo">Venmo</label><br><br>

        <input type="submit" value="Submit" name="submit_payment">

      </form>
      <?php
      if (isset($_POST['submit_payment'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $amount = $_POST['amount'];
        $service = $_POST['service'];

        $subject = "PAYMENT RECIEVED FROM " . $name . "-" . $email;
        $message = $name . " has submitted a payment of $" . $amount . " through " . $service . ". Please confirm by checking
            the " . $service . " account and approve it here for the record.";

        $query = "INSERT INTO notifications(notificationType, notificationSubject, notificationMessage, notificationFlag)
                  VALUES ('Monetary Donation', :subject, :message, 0)";

        try {
            $prepared_stmt = $dbo->prepare($query);
            $prepared_stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
            $prepared_stmt->bindValue(':message', $message, PDO::PARAM_STR);
            $prepared_stmt->execute();
        } catch (PDOException $ex) { // Error in database processing.
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }
      }
      ?>
    </div>
    <div class="cashapp_info" style="display:none">
      <h4>Redirecting to...</h4>
      <img src="images/cashapp_logo.png" alt="">
      <h6>How to submit payment via Venmo</h6>
      <ol>
        <li>Sign in to Cash App through the website or mobile.</li>
        <li>Click the Pay or New button.</li>
        <li id="pay_amount">Enter the amount you specified in the form: $</li>
        <li id="full_name">In the description, put ".</li>
        <li>Submit your payment.</li>
      </ol>
    </div>

    <div class="paypal_info" style="display:none">
      <h4>Redirecting to...</h4>
      <img src="images/paypal_logo.png" alt="">
      <h6>How to submit payment via PayPal</h6>
      <ol>
        <li></li>
      </ol>
    </div>

    <div class="venmo_info" style="display:none">
      <h4>Your selected payment method is: </h4>
      <img src="images/venmo_logo.png" alt=""><br>
      <h6>How to submit payment via Venmo</h6>
      <ol>
        <li>Login to Venmo on your mobile device.</li>
        <li>Click the "Pay or Request button"</li>
        <li>The recipient of the payment is: @ElegantHB</li>
        <li id="pay_amount">Enter the amount you specified in the form: $</li>
        <li>In the description, put "{Full Name} - HeartbreAKA Donation". For example,
          if your name is Mary Smith, then you would put "Mary Smith - HeartbreAKA Donation."</li>
        <li>Submit your payment</li>
      </ol>
      <br>
      <p><strong>Upon verifying your submission, you will recieve an email
        with the amount credited to your account.</strong></p>
    </div>
    <!-- This class defines and structures the overlay navigation bar-->
    <!-- It includes the content and functions of the nav bar-->
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
        <a href="donations-money.html">Monetary Donations</a>
        <a href="donations-dropbox.html">Dropbox Donations</a>
      </div>
      <a href="bachelors.php">Bachelors</a>
      <a href="auction.html">HeartbreAKA Auction</a>
    </div>

  </div>
</div>



<script type="text/javascript">
/*This section creates t*/

function submitForm() {

  var paypal = form.service[0];
  var cashapp = form.service[1];
  var venmo = form.service[2];

  if (paypal.checked == true) {
    document.getElementById("paypal_info").style.display = "block";
  }

  if (cashapp.checked == true) {
    window.open("https://cash.app/");
    document.getElementById("cashapp_info").style.display = "block";
  }

  if (venmo.checked == true) {
    document.getElementById("venmo_info").style.display = "block";
  }
}

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
  <script type="text/javascript" src="js/donations-money.js"></script>

  </body>
</html>
