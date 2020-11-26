<?php

require_once("conn.php");
checkDatabaseStatus();

$query = "SELECT * FROM aka.bachelors";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();

} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/donations-dropbox.css">
    <script type="text/javascript" src="js/donations-dropbox.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
  </head>
  <body>

  <?php include_once("header.php"); ?>

  <div class="dropbox_attendee">
      <h2>Donations via Dropbox</h2>
      <p>Beginning on January 15, you will be able to drop off your donations in
        the following locations in the boxes that look like the picture showed on
        this page.
        <ul>
          <li>Rand</li>
          <li>NPHC House</li>
          <li>Commons Center</li>
          <li>Kissam Center</li>
        </ul><br>
        We ask that if you are dropping off an item, please label it with your
        name and email address associated with the account. After you have dropped
        it off, fill out the form below specifying what is in the box and how much
        of each item to determine how many AKA dollars you can be rewarded. Upon
        submission, your donation will be reviewed by the chapter and funds will
        be allocated to your account as soon as possible. If you have any questions,
        feel free to reach out to the chapter through this
        <a href="mailto:aka.vanderbilt@gmail.com?subject=HeartbreAKA%20Inquiry%20about%20Dropbox%20Donations">email</a>.</p>

        <form class="" action="donations-dropbox.php" method="post">
          <label for="full_name">Full Name</label><br>
          <input type="text" name="full_name"><br>

          <label for="email">Email</label><br>
          <input type="email" name="email"><br>

          <label for="donations">Donations</label><br>
          <input type="checkbox" name="donations" value="">
          <label for="checkbox" name="donations" value=""></label>
        </form>
  </div>

  <?php include_once("overlay.php"); ?>





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
