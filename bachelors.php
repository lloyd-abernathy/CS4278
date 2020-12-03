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
            <div class="bachelors_gallery" onclick="showDiv('<?php echo $bachelorID; ?>')">
                <?php if ($bachelorProfilePicture) { ?>
                    <img src="<?php echo $bachelorProfilePicture; ?>" alt="">
                <?php } else { ?>
                    <img src="https://i.stack.imgur.com/YQu5k.png" alt="">
                <?php }; ?>
                <div class="desc">
                    <strong><?php echo $bachelorFullName; ?></strong><br>
                    <strong>Major: </strong><?php echo $bachelorMajor; ?><br>
                </div>
            </div>
            <div class="biography" id="<?php echo $bachelorID; ?>">
                <span onclick="hideDiv('<?php echo $bachelorID; ?>')"
                      class="closebtn">&times;</span>

                <div class="bachelor_info">

                    <h3>About <?php echo $bachelorFullName; ?></h3>
                    <div class="bachelor_img">
                        <?php if ($bachelorProfilePicture) { ?>
                            <img src="<?php echo $bachelorProfilePicture; ?>" alt="">
                        <?php } else { ?>
                            <img src="https://i.stack.imgur.com/YQu5k.png" alt="">
                        <?php }; ?>
                    </div>
                    <div>
                      <p>
                          <strong>Clasification: </strong><?php echo $bachelorClass; ?> <br>
                          <strong>Major: </strong> <?php echo $bachelorMajor; ?> <br>
                          <strong>Max Bid (AKA Dollars): $</strong> <?php echo $bachelorMaxBid; ?><br>
                          <strong>Auction Status: </strong> <?php
                          if ($bachelorAuctionStatus == 0) {
                              ?>
                              <strong style="color:green">AVAILABLE</strong>
                              <?php
                          } else {
                              ?>
                              <strong style="color:red">TAKEN</strong>
                              <?php
                          } ?><br>
                          <!-- Add biography here -->
                          <u><strong>BIOGRAPHY</strong></u><br>
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
                      </p>
                    </div>
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
                Check back later to see the list of bachelors for this year's heartbreAKA
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
</script>
</body>
</html>
