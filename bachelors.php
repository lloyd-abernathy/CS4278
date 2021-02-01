<?php

require_once("conn.php");

$query = "SELECT * FROM aka.bachelors WHERE addedBy IS NOT NULL";

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
    <title>Bachelors</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/bachelors.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/bachelors.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body>
<?php include_once("header.php"); ?>
<?php include_once("overlay.php"); ?>

</div>
<div class="Bachelors">
    <body>
    <h2>Bachelors</h2>
    <?php if (isset($result) && $prepared_stmt->rowCount() > 0) {
      ?>
      <p>
        Here are the bachelors for this year! To see more information about each bachelor:
        <ul>
          <li><strong>Laptop/Computer</strong>: Click on the bachelor you wish to see more information on.</li>
          <li><strong>Mobile Device</strong>: Swipe left on the bachelor you wish to see more information on.</li>
        </ul>
      </p>
      <?php
        foreach ($result as $row) {
          $bachelorID = $row['bachelorId'];
          $bachelorFullName = $row['fullName'];
          $bachelorClass = $row['class'];
          $bachelorMajor = $row['major'];
          $bachelorBiography = $row['biography'];
          $bachelorProfilePicture = $row['photoUrl'];
          $bachelorMaxBid = $row['maxBid'];
          $bachelorAuctionStatus = $row['auctionStatus'];
          $bachelorAddedBy = $row['addedBy']; ?>
            <div class="bachelors_gallery" ontouchstart="this.classList.toggle('hover');">
              <div class="flip-card-inner">
                <div class="flip-card-front">
                  <div class="bachelor_img">
                    <?php
                      $bachelorPhotoArr = explode("/", $bachelorProfilePicture);
                      $encodePhoto = urlencode(array_pop($bachelorPhotoArr));
                      $bachelorProfilePicture = implode("/", $bachelorPhotoArr) . "/" . $encodePhoto;

                     ?>
                    <img src="<?php echo $bachelorProfilePicture; ?>" alt="">
                  </div>
                  <div class="desc">
                    <strong><?php echo strtoupper($bachelorFullName); ?></strong><br>
                    <strong>Clasification: </strong><?php echo $bachelorClass; ?> <br>
                    <strong>Major: </strong> <?php echo $bachelorMajor; ?> <br>
                    <strong>Winning Bid (AKA Dollars): $</strong><?php echo $bachelorMaxBid; ?><br>
                    <strong>Auction Status: </strong> <?php
                    if ($bachelorAuctionStatus == 0) {
                        ?>
                        <strong style="color:green">AVAILABLE</strong>
                        <?php
                    } else {
                        ?>
                        <strong style="color:red">TAKEN</strong>
                        <?php
                    } ?>
                  </div>
                  <div class="more_info">
                    <p style="text-align: right; font-size: 15px;">More Info <i class="fa fa-share"></i></p>
                  </div>
                </div>
                <div class="flip-card-back">
                  <p>
                      <!-- Add biography here -->
                      <strong>BIOGRAPHY</strong><br>
                      <div class="bachelor_questions">
                        <table>
                          <tbody>
                            <?php
                            $bachelorBiographyArr = explode("||", $bachelorBiography);
                            foreach ($bachelorBiographyArr as $str) {
                            $question = explode("=", $str);
                            ?>
                            <tr>
                              <td id="question"><strong><?php echo $question[0]; ?></strong></td>
                              <td><?php echo substr($question[1], 1, -1); ?></td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <br><br>
                    <div class="more_info">
                      <p style="text-align: right; font-size: 15px;">Close  <i class="fa fa-times"></i></p>
                    </div>
                  </p>
                </div>
              </div>
            </div>
            <div class="biography" id="<?php echo $bachelorID; ?>">

                <div class="bachelor_info">

                    <!-- <h3 style="width: 60%; margin-left: 20%;">About <?php echo $bachelorFullName; ?></h3> -->

                </div>
            </div>
        <?php }
    } else {
        if ($admin_flag) {
            ?>
            <h4>No bachelors are being presented right now!</h4>
            <p>
                You can have bachelors sign up through <a href="bachelor-signup.php">this form</a>
                and approve any recently signed up bachelors from your account page: <a
                        href="account.php">here</a>.
            </p>
            <?php
        } else {
            ?>
            <h4>Bachelors Coming Soon!</h4>
            <p>
                Check back later to see the list of bachelors for this year's HeartbreAKA
                event.
            </p>
            <?php
        }
    } ?>

    </body>
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
<script>
    function showDiv(bachelorID) {
        document.getElementById(bachelorID).style.display = "block";
    }

    function hideDiv(bachelorID) {
        document.getElementById(bachelorID).style.display = "none";
    }

    $(document).on("click", ".bachelors_gallery", function () {
        $(this).toggleClass('hover');
    });
</script>
<script type="text/javascript" src="js/cookies-enable.js"></script>

</body>
</html>
