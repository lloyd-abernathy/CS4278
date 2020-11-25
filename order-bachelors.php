<?php
$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

$bachelors = "SELECT * FROM aka.bachelors ORDER BY auction_order_id ASC";

$auction_order = "SELECT auction_order_id FROM aka.bachelors";

try {
    $bachelors_prepared_stmt = $dbo->prepare($bachelors);
    $bachelors_prepared_stmt->execute();
    $bachelors_result = $bachelors_prepared_stmt->fetchAll();

    $auction_order_prepared_stmt = $dbo->prepare($auction_order);
    $auction_order_prepared_stmt->execute();
    $auction_order_result = $auction_order_prepared_stmt->fetchAll();
    print_r($auction_order_result);

} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order Bachelors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/order-bachelors.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/order-bachelors.js"></script>
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

      <div class="order_bachelors_info">
        <h2>Choose the Order of Bachelors</h2>
        <br>
          <?php
          if ($bachelors_result && $bachelors_prepared_stmt->rowCount() > 0) {
            $size = $bachelors_prepared_stmt->rowCount();

           ?>
           <p>Please click on the bachelors and add them  in the order
             you want to present them in during the auction. When done, click submit
             to update it.</p>
           <br>
           <div class="order_bachelors_select">
             <form class="reorder_bachelors" method="post" action="order-bachelors.php">
             <div class="current_select">
               <select id="current_order" class="current_order" name="current_order" size="20" multiple>
                 <?php
                   foreach ($bachelors_result as $row) {
                     $bachelorID = $row['bachelorId'];
                     $bachelorFirstName = $row['firstName'];
                     $bachelorLastName = $row['lastName'];
                     ?>
                     <option class="bachelor" value="<?= $bachelorID ?>"><?php echo $bachelorFirstName . " " . $bachelorLastName; ?></option>
                     <?php
                   }
                 }
                 ?>
               </select>
             </div>

              <div class="buttons">
                <button type="button" name="button" onclick="moveToRight()">
                  <i class="fa fa-arrow-right"></i>
                </button><br>
                <button type="button" name="button" onclick="moveToLeft()">
                  <i class="fa fa-arrow-left"></i>
                </button>
              </div>

                <div class="new_select">
                  <select class="new_order" name="new_order[]" size="20" multiple>

                  </select>
                </div>
                <input id="submit_order" type="submit" name="submit_order" value="Submit New Order">

            </form>
            <?php
            if (isset($_POST['submit_order'])) {
              $auction_order_null = "UPDATE aka.bachelors SET auction_order_id = NULL";

              try {
                $auction_order_null_prepared_stmt = $dbo->prepare($auction_order_null);
                $auction_order_null_prepared_stmt->execute();
              } catch (PDOException $ex) {
                echo $sql . "<br>" . $error->getMessage();
              }
              if (isset($_POST['new_order'])) {
                $new_order = $_POST['new_order'];
                $index = 1;
                $x = 0;
                print_r($new_order);
                foreach ($new_order as $id) {
                  $new_order_query = "UPDATE aka.bachelors
                                      SET auction_order_id = :index
                                      WHERE bachelorId = :id";

                  try {
                      $new_order_prepared_stmt = $dbo->prepare($new_order_query);
                      $new_order_prepared_stmt->bindValue(':id', $id[$x], PDO::PARAM_INT);
                      $new_order_prepared_stmt->bindValue(':index', $index, PDO::PARAM_INT);
                      $new_order_prepared_stmt->execute();
                      $index++;
                      $x++;
                  } catch (PDOException $ex) { // Error in database processing.
                      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                  }
                }

                $get_null_auction_order = "SELECT *
                                           FROM aka.bachelors
                                           WHERE auction_order_id = '' ";
                $bachelors_now = "SELECT * FROM aka.bachelors";

                try {
                  $get_null_auction_order_prepared_stmt = $dbo->prepare($get_null_auction_order);
                  $get_null_auction_order_prepared_stmt->execute();
                  $get_null_auction_order_result = $get_null_auction_order_prepared_stmt->fetchAll();

                  $bachelors_now_prepared_stmt = $dbo->prepare($bachelors_now);
                  $bachelors_now_prepared_stmt->execute();
                  $bachelors_now_result = $bachelors_now_prepared_stmt->fetchAll();
                } catch (PDOException $ex) {
                  echo $sql . "<br>" . $error->getMessage();
                }

                if ($get_null_auction_order_result && $get_null_auction_order_prepared_stmt->rowCount() > 0) {
                  ?>
                  Error! Please resubmit with all values added to the right side.
                  <?php
                } else {
                  print_r($get_null_auction_order_result);
                  ?>
                  Successfully submitted! Order of bachelors updated.
                  <?php
                }
            }

          }?>
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
