<?php

require_once("conn.php");

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
    </div>

    <div class="dropbox_admin">
      <h2>List of Dropbox Donations</h2>
      <table id="dropbox_donations_list">
        <thead>
          <th>Name</th>
          <th>Email</th>
          <th>Donation</th>
          <th>Date Submitted</th>
          <th>AKA Dollar Equivalence</th>
          <th>Accept or Deny?</th>
        </thead>

        <tbody id="dropbox_donations_list_body">

        </tbody>
      </table>
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
