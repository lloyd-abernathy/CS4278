<?php

require_once("conn.php");
require_once("createflags.php");
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
    <title>Donations via Dropbox</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/donations-dropbox.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
</head>
<body>

<?php
include_once("header.php");
?>
<h2>Donations via Dropbox</h2>
<div class="">

</div>
<?php
if ($admin_flag || $bachelor_flag) {
    ?>
    <p>
        <strong>NOTE: You will not be awarded any AKA dollars, but you are welcome
            to donate at any of the listed locations!</strong>
    </p><br>
    <?php
}
?>
<p>Beginning on January 15, you will be able to drop off your donations in
    the following locations in the boxes that look like the picture showed on
    this page.
<ul>
    <li>Rand</li>
    <li>NPHC House</li>
    <li>Commons Center</li>
    <li>Kissam Center</li>
</ul>
<br>
<?php
if ($attendee_flag) {
    ?>
    We ask that if you are dropping off an item, please label it with your
    name and email address associated with the account. After you have dropped
    it off, fill out the form below specifying what is in the box and how much
    of each item to determine how many AKA dollars you can be rewarded. Upon
    submission, your donation will be reviewed by the chapter and funds will
    be allocated to your account as soon as possible. If you have any questions,
    feel free to reach out to the chapter through this
    <a href="mailto:aka.vanderbilt@gmail.com?subject=HeartbreAKA%20Inquiry%20about%20Dropbox%20Donations">email</a>.</p>
    <br>
    <?php
    if (isset($_POST['dropbox_donation'])) {
        $isSuccess = (bool) false;
        if ($attendee_flag) {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $donations = $_POST['donations'];
            $bank = $_POST['total'];
            $donationsArr = array();
            for ($x = 0; $x < count($donations); $x = $x + 2) {
                $donationsArr[$donations[$x]] = $donations[$x + 1];
            }
            $donationsString = implode('||', array_map(
                function ($v, $k) {
                    return sprintf("%s='%s'", $k, $v);
                },
                $donationsArr,
                array_keys($donationsArr)
            ));
            $subject = "DROPBOX DONATION RECEIEVED FROM: " . $full_name;
            $message = "Name: " . $full_name . ", Email: " . $email . ", Donations: "
                . $donationsString . ", AKA Dollars: " . $bank;

            $query = "INSERT INTO notifications(notificationType, notificationSubject, notificationMessage, notificationFlag, notificationApproved)
                    VALUES ('Dropbox Donation', :subject, :message, 0, 0)";

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
              <span class="form_submission_successful">Form Submitted Successfully!</span>
              <?php
            } else {
              ?>
              <span class="form_submission_error">Error in submitting form! Please
                contact Erin at <a href="mailto:erin.hardnett.1@vanderbilt.edu">this email.</a>
              </span>
              <?php
            }

        }
    }
     ?>

    <form action="donations-dropbox.php" method="post" name="dropbox">
        <label for="full_name">Full Name</label><br>
        <input type="text" name="full_name" value="<?php echo $login_result['fullName']; ?>"
               readonly required><br><br>

        <label for="email">Email</label><br>
        <input type="email" name="email" value="<?php echo $login_result['email']; ?>" readonly
               required><br><br>

        <u><strong>Donations (Select the amount in donations for each)</strong></u><br>

        <label for="donations[]">Individual Paintbrushes</label>
        <input type="hidden" name="donations[]" value="Individual Paintbrushes">
        <input type="number" name="donations[]" min="0" value="0" onchange="updateAKADollars()"><br>
        <label for="donations[]">Box of Crayons</label>
        <input type="hidden" name="donations[]" value="Box of Crayons">
        <input type="number" name="donations[]" min="0" value="0" onchange="updateAKADollars()"><br>
        <label for="donations[]">Box of Markers</label>
        <input type="hidden" name="donations[]" value="Box of Markers">
        <input type="number" name="donations[]" min="0" value="0" onchange="updateAKADollars()"><br>
        <label for="donations[]">Paint Set</label>
        <input type="hidden" name="donations[]" value="Paint Set">
        <input type="number" name="donations[]" min="0" value="0" onchange="updateAKADollars()"><br>
        <label for="donations[]">Packet of Construction Paper</label>
        <input type="hidden" name="donations[]" value="Packet of Construction Paper">
        <input type="number" name="donations[]" min="0" value="0" onchange="updateAKADollars()"><br>
        <!-- <input type="checkbox" name="donations[]" value="other">
        <label for="donations[]">Other</label>
        <input type="number" name="donations[]" value="other"> -->
        <p id="aka_dollars">AKA Dollars Amount: </p><br>
        <input type="hidden" name="total" value="0">

        <input type="submit" name="dropbox_donation" value="Submit Donation">
    </form>
    <?php
} else {
    ?>
    <p>
        <strong>
            If you plan to attend the event, please sign in from the navigation
            bar so that you can recieve credit for making this donation. If not,
            we appreciate your donation to the chapter for our cause!
        </strong>
    </p>
    <?php
}
?>


<?php

include_once("overlay.php");

?>

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
<script type="text/javascript" src="js/donations-dropbox.js"></script>

</body>
</html>
