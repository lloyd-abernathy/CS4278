<?php
$dbhost = ' ';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

$to_do_query = "SELECT * FROM aka.notifications WHERE notificationFlag = 0";
$done_query = "SELECT * FROM aka.notifications WHERE notificationFlag = 1";

try {
    $to_do_prepared_stmt = $dbo->prepare($to_do_query);
    $to_do_prepared_stmt->execute();
    $to_do_result = $to_do_prepared_stmt->fetchAll();

    $done_prepared_stmt = $dbo->prepare($done_query);
    $done_prepared_stmt->execute();
    $done_result = $to_do_prepared_stmt->fetchAll();

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
    <link rel="stylesheet" href="css/donations-admin-list.css">
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/donations-admin-list.js"></script>
    <script type="text/javascript" src="js/donations-money.js"></script>
    <script type="text/javascript" src="js/donations-dropbox.js"></script>
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

    <div class="donations_admin_list_info">
      <h2>Tasks To Do</h2>
      <form class="" action="donations-admin-list.php" method="post" onsubmit="">

            <?php
            if ($to_do_result && $to_do_prepared_stmt->rowCount() > 0) {?>
              <table>
                <thead>
                  <th>&nbsp;</th>
                  <th>Message</th>
                  <th>Approved?</th>
                </thead>
                <tbody>
              <?php
              foreach ($to_do_result as $row) {
                ?>
                <tr>
                  <td>
                    <input type="checkbox" value="<?php echo $row["notificationId"]; ?>">
                  </td>
                  <td>
                    <strong>Subject: </strong> <?php echo $row["notificationSubject"]; ?><br>
                    <strong>Message: </strong> <?php echo $row["notificationMessage"]; ?>
                  </td>
                  <td>
                    <input type="radio" name="approved" value="Approve">
                    <label for="approved">Approve</label><br>
                    <input type="radio" name="approved" value="Deny">
                    <label for="approved">Deny</label><br>
                    <input type="radio" name="approved" value="Edit">
                    <label for="approved">Edit</label>
                  </td>
                </tr>

                <?php
              }
            } else {?>
              No more Tasks to complete
            }?>


          </tbody>
        </table>
        <input type="submit" name="submit_changes" value="Submit Changes">
      </form>

      <h2>Completed Tasks</h2>
      <form class="" action="donations-admin-list.php" method="post">

      </form>
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
