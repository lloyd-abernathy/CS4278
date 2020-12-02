<?php

require_once("conn.php");
require_once("createflags.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>View Profile</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script type="text/javascript" src="js/account.js"></script>
</head>
<body>
<?php include_once("header.php"); ?>
<?php include_once("overlay.php"); ?>

</div>

<div class="account_info">
    <h2>View Profile</h2>
    <table class="profile">

        <tbody>
        <tr>
            <td>
              <strong>Name</strong>
            </td>
            <td><?php echo $login_result['fullName']; ?></td>
        </tr>
        <tr>
            <td>
              <strong>Email</strong>
            </td>
            <td><?php echo $login_result['email']; ?></td>
        </tr>
        <?php
          if ($attendee_flag) {
            ?>
            <tr>
                <td>
                  <strong>AKA Dollars Balance</strong>
                </td>
                <td><?php echo "$" . $login_result['accountBalance']; ?></td>
            </tr>
            <tr>
              <td>
                <strong>Total Monetary Donations</strong>
              </td>
              <td><?php echo "$" . $login_result['totalDonations']; ?></td>
            </tr>
            <tr>
              <td>
                <strong>Bachelor Won</strong>
              </td>
              <td><?php
              $auctionWon = $login_result['auctionWon'];
              if ($auctionWon == 1) {
                $winning_query = "SELECT AUC.winningAttendeeId,
                                    AUC.auctionId,
                                   AUC.winningBid AS bidAmount,
                                   BACH.fullName AS bachelor,
                                   ATT.fullName AS attendee
                            FROM aka.auctions AUC
                            JOIN aka.bachelors BACH ON AUC.bachelorId = BACH.bachelorId
                            JOIN aka.attendees ATT ON AUC.winningAttendeeId = ATT.attendeeId
                            WHERE AUC.winningAttendeeId = :id
                            ORDER BY AUC.auctionId ASC";

                try {
                  $winning_prepared_stmt = $dbo->prepare($winning_query);
                  $winning_prepared_stmt->bindValue(':id', $login_result['id'], PDO::PARAM_INT);
                  $winning_prepared_stmt->execute();
                  $winning_result = $winning_prepared_stmt->fetchAll();
                } catch (PDOException $ex) {
                  echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }

                if (isset($winning_result) && $winning_prepared_stmt->rowCount() > 0) {
                  foreach ($winning_result as $winner) {
                    print_r($winner['bachelor']);
                    ?>
                    <br>
                    <?php
                  }
                }
              } else {
                // TODO: Change based on time of the event in database
                print_r("N/A");
              }
               ?></td>
            </tr>
            <?php
          }

          if ($bachelor_flag) {
            ?>
            <tr>
              <td>
                <strong>Classification</strong>
              </td>
              <td><?php echo $login_result['class']; ?></td>
            </tr>
            <tr>
              <td>
                <strong>Major</strong>
              </td>
              <td><?php echo $login_result['major']; ?></td>
            </tr>

              <?php
              $bachelorBiographyArr = explode("||", $login_result['biography']);
              foreach ($bachelorBiographyArr as $str) {
                $question = explode("=", $str);
                ?>
              <tr>
                <td>
                  <strong><?php echo $question[0]; ?></strong>
                </td>
                <td><?php echo substr($question[1], 1, -1); ?></td>
              </tr>
                <?php
              }
              ?>
            <tr>
              <td>
                <strong>Photo</strong>
              </td>
              <td>
                <img src=<?= $login_result['photoUrl'] ?> alt="">
              </td>
            </tr>
            <?php
          }
         ?>
        </tbody>
    </table>
    <?php
    ?>
    <div class="links">
    <?php
      if ($attendee_flag) {
        ?>
        <form action="donations-money.php">
          <input class="quick_links" type="submit" name="monetary_donation"
                value="Make Monetary Donations">
        </form>
        <form action="donations-dropbox.php">
          <input class="quick_links" type="submit" name="dropbox_donation"
                value="Make Dropbox Donations">
        </form>
        <form action="bachelors.php">
          <input class="quick_links" type="submit" name="dropbox_donation"
                value="View Bachelors">
        </form>
        <?php
      }
      if ($bachelor_flag) {
        if ($login_result['addedBy'] !== null) {
          ?>
          <form action="edit-bachelor.php">
            <input class="quick_links" type="submit" name="edit_bachelor"
                  value="Edit Bachelor Profile">
          </form>
          <?php
        } else {
          ?>
          <h4>This button will be enabled when your
            application is approved.</h4>
          <form action="edit-bachelor.php">
            <input class="quick_links_disabled" type="submit" name="edit_bachelor"
                  value="Edit Bachelor Profile" disabled>
          </form>
          <?php
        }

      }

      if ($admin_flag) {
        ?>
        <form action="donations-admin-list.php">
          <input class="quick_links" type="submit" name="tasks"
                value="View Tasks to Complete">
        </form>
        <form action="add-delete-admins.php">
          <input class="quick_links" type="submit" name="admins"
                value="Add/Delete Admins">
        </form>
        <form action="order-bachelors.php">
          <input class="quick_links" type="submit" name="order-bachelors"
                value="Decide Bachelor Order">
        </form>
        <form action="add-bachelors.php">
          <input class="quick_links" type="submit" name="add-bachelors"
                value="Add Bachelors to Page">
        </form>
        <?php
      }

     ?>
   </div>

</div>

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
</body>
</html>
