<?php

require_once("conn.php");
require_once("createflags.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Monetary Donations</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/donations-money.css">
    <link rel="stylesheet" href="css/payment.css">
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
</head>
<body>

<?php include_once("header.php"); ?>
<h2>Make a Monetary Donation</h2><br>
<div class="monetary_donations_everyone">
  <?php
  if (!$attendee_flag) {
    ?>
    <p>
      <strong>
        If you plan to attend HeartbreAKA, please log in/create an account from
        the navigation bar so that you can have your donation credited to your
        account.
      </strong><br>
      For HeartbreAKA, we are accepting monetary donations to donate to the
      <a href="https://www.maryparrish.org/">Mary Parrish Center</a>.
      You can use the following payment methods to make a contribution and follow
      the instructions to make your donation:
    </p><br>
    <div class="payment_rows">
        <div class="column_left">
          <h3>PayPal</h3>
            <p>Instructions Coming Soon!</p>
        </div>
        <div class="column_middle">
          <h3>Cash App: <a href="https://cash.app/">https://cash.app/</a></h3>
            <ol>
                <li>Sign in to Cash App through the website or mobile.</li>
                <li>Click the Pay or New button.</li>
                <li>Enter the amount you would like to donate.</li>
                <li>In the description, put "{Full Name} - HeartbreAKA Donation". For example,
                    if your name is Mary Smith, then you would put "Mary Smith - HeartbreAKA Donation."
                </li>
                <li>The recipient is: $elegantetabeta.</li>
                <li>Submit your payment!</li>
            </ol>
        </div>
        <div class="column_right">
          <h3>Venmo</h3>
            <ol>
                <li>Login to Venmo app on your mobile device.</li>
                <li>Click the "Pay or Request button"</li>
                <li>Enter the amount you would like to donate.</li>
                <li>In the description, put "{Full Name} - HeartbreAKA Donation". For example,
                    if your name is Mary Smith, then you would put "Mary Smith - HeartbreAKA Donation."
                </li>
                <li>The recipient of the payment is: @ElegantHB</li>
                <li>Submit your payment!</li>
            </ol>
        </div>
    </div>
    <?php
  }?>
</div>

<div class="monetary_donations_attendee">
  <?php
     if ($attendee_flag) {
      ?>
      <p>
        On this page, you are able to submit a form with your monetary donation
        that will be converted to AKA Dollars for HeartbreAKA. Please submit the
        form below and follow the instructions listed for the payment method. Upon
        submitting, your donation will be sent in for approval and the money will
        be credited to your account as soon as it has been approved. We appreciate
        your generous contribution to our cause and hope you enjoy HeartbreAKA!
      </p><br>
      <?php
      if (isset($_POST['submit_payment']) && $attendee_flag) {
          $isSuccess = (bool)false;
          $name = $_POST['name'];
          $email = $_POST['email'];
          $amount = $_POST['amount'];
          $service = $_POST['service'];

          $subject = "PAYMENT RECIEVED FROM: " . $name;
          $message = "Name: " . $name . ", Email: " . $email . ", Amount ($): " . $amount . ",
                      Service Used: " . $service . ", Task: Please confirm this payment method
                      by checking the " . $service . " account and approve it here for the record.";

          $query = "INSERT INTO notifications(notificationType, notificationSubject, notificationMessage, notificationFlag, notificationApproved)
                    VALUES ('Monetary Donation', :subject, :message, 0, 0)";

          try {
              $prepared_stmt = $dbo->prepare($query);
              $prepared_stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
              $prepared_stmt->bindValue(':message', $message, PDO::PARAM_STR);
              $prepared_stmt->execute();
              $isSuccess = (bool)true;
          } catch (PDOException $ex) { // Error in database processing.
              echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
          }

          if ($isSuccess) {
            ?>
            <h6 class="form_submission_successful">Form Submitted Successfully!</h6><br>
            <?php
          } else {
            ?>
            <h6 class="form_submission_error">Error in submitting form! Please
              contact Erin at <a href="mailto:erin.hardnett.1@vanderbilt.edu">this email.</a>
            </h6><br>
            <?php
          }
      }
      ?>
    <form class="monetary_donations_form" action="" method="post" name="monetary"
          onsubmit="submitForm()">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo $login_result['fullName']; ?>" readonly required><br><br>

        <label for="email">Email Address</label>
        <input type="email" name="email"  value="<?php echo $login_result['email']; ?>" readonly required><br><br>

        <label for="amount">Dollar Amount $ </label>
        <input id="dollar_amount" type="number" name="amount" onchange="updateAKADollars()" min="1"
               required>
        <p id="aka_dollars">AKA Dollars Amount: </p><br>

        <label for="service">What payment service would you like to use?</label><br>
        <input type="radio" id="paypal" name="service" value="PayPal" disabled>
        <label for="paypal">PayPal</label><br>
        <input type="radio" id="cashapp" name="service" value="Cash App" checked>
        <label for="cashapp">Cash App</label><br>
        <input type="radio" id="venmo" name="service" value="Venmo">
        <label for="venmo">Venmo</label><br><br>

        <input type="submit" value="Submit" name="submit_payment">

    </form><br>
    <div class="payment_rows">
        <div class="column_left">
          <h3>PayPal</h3>
            <p>Instructions Coming Soon!</p>
        </div>
        <div class="column_middle">
          <h3>Cash App: <a href="https://cash.app/">https://cash.app/</a></h3>
            <ol>
                <li>Sign in to Cash App through the website or mobile.</li>
                <li>Click the Pay or New button.</li>
                <li>Enter the amount you would like to donate.</li>
                <li>In the description, put "{Full Name} - HeartbreAKA Donation". For example,
                    if your name is Mary Smith, then you would put "Mary Smith - HeartbreAKA Donation."
                </li>
                <li>The recipient is: $elegantetabeta.</li>
                <li>Submit your payment!</li>
            </ol>
        </div>
        <div class="column_right">
          <h3>Venmo</h3>
            <ol>
                <li>Login to Venmo app on your mobile device.</li>
                <li>Click the "Pay or Request button"</li>
                <li>Enter the amount you would like to donate.</li>
                <li>In the description, put "{Full Name} - HeartbreAKA Donation". For example,
                    if your name is Mary Smith, then you would put "Mary Smith - HeartbreAKA Donation."
                </li>
                <li>The recipient of the payment is: @ElegantHB</li>
                <li>Submit your payment!</li>
            </ol>
        </div>
    </div>
    <?php
  }
   ?>

</div>
<!-- This class defines and structures the overlay navigation bar-->
<!-- It includes the content and functions of the nav bar-->
<?php include_once("overlay.php"); ?>


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
<script type="text/javascript" src="js/donations-money.js"></script>
<script type="text/javascript" src="js/cookies-enable.js"></script>

</body>
</html>
