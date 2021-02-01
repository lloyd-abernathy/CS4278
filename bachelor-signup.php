<?php
require_once("conn.php");
require_once("createflags.php");

$sql_mode = "SET sql_mode=''";
$foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
try {
    $sql_mode_prepared_stmt = $dbo->prepare($sql_mode);
    $sql_mode_prepared_stmt->execute();
    $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
    $foreign_checks_zero_prepared_stmt->execute();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
print_r($_COOKIE);
if (isset($_COOKIE["photo"])) {
  // print_r("began adding to database");
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $find_bachelor = "SELECT * FROM aka.bachelors WHERE email = :email";
    try {
        $find_bachelor_prepared_stmt = $dbo->prepare($find_bachelor);
        $find_bachelor_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $find_bachelor_prepared_stmt->execute();
        $find_bachelor_result = $find_bachelor_prepared_stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }

    $isSuccess = (bool)false;
    if ($find_bachelor_prepared_stmt->rowCount() == 0) {
        $major = $_POST['major'];
        $class = $_POST['class'];
        $hometown_state = $_POST['hometown_state'];
        $food = $_POST['food'];
        $hobbies = $_POST['hobbies'];
        $pet_peeves = $_POST['pet_peeves'];
        $dream_date = $_POST['dream_date'];
        $biography = array(
            "Hometown, State" => $hometown_state,
            "What is your favorite food?" => $food,
            "What are your favorite hobbies?" => $hobbies,
            "What are your biggest pet peeves?" => $pet_peeves,
            "What is your dream date?" => $dream_date
        );
        $biographyStr = implode('||', array_map(
            function ($v, $k) {
                return sprintf("%s='%s'", $k, $v);
            },
            $biography,
            array_keys($biography)
        ));
        $uploadedImageLocation = $_COOKIE["photo"];
        $add_bachelor = "INSERT INTO bachelors (fullName, email, class, major, biography, photoUrl, maxBid, auctionStatus, addedBy, auction_order_id)
                         VALUES (:fullName, :email, :class, :major, :biography, :photoUrl, 0.00, 0, NULL, 0)";

        try {
            $add_bachelor_prepared_stmt = $dbo->prepare($add_bachelor);
            $add_bachelor_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->bindValue(':biography', $biographyStr, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->bindValue(':photoUrl', $uploadedImageLocation, PDO::PARAM_STR);
            $add_bachelor_prepared_stmt->execute();
            $isSuccess = (bool)true;
        } catch (PDOException $ex) { // Error in database processing.
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

        $is_attendee = (bool)false;

        $find_attendee_info = "SELECT * FROM aka.attendees WHERE email = :email";

        try {
            $find_attendee_info_prepared_stmt = $dbo->prepare($find_attendee_info);
            $find_attendee_info_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $find_attendee_info_prepared_stmt->execute();
            $find_attendee_info_result = $find_attendee_info_prepared_stmt->fetchAll();
        } catch (PDOException $ex) {
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

        if (isset($find_attendee_info_result) && $find_attendee_info_prepared_stmt->rowCount() == 1) {
            $is_attendee = (bool)true;
            $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
            $delete_from_attendee = "DELETE FROM aka.attendees WHERE email = :email";

            try {
                $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
                $foreign_checks_zero_prepared_stmt->execute();

                $delete_from_attendee_prepared_stmt = $dbo->prepare($delete_from_attendee);
                $delete_from_attendee_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $delete_from_attendee_prepared_stmt->execute();
                $is_attendee = (bool)false;
            } catch (PDOException $ex) {
                echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
            }
        }
        ?>
        <script type="text/javascript">
        function deleteCookie(name) {
          document.cookie = name+ "=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/;";
        }
        deleteCookie('photo');
        </script>
        <?php

        if ($isSuccess && !$is_attendee) {
          ?>
          <h6 class="form_submission_successful">Form Submitted Successfully!</h6><br>
          <?php
        } else if ($isSuccess && $is_attendee){
          ?>
          <h6 class="form_submission_successful">Form Submitted Successfully!</h6><br>
          </h6><br>
          <h6 class="form_submission_error">You are still registered as an attendee!
            Please contact Erin with <a href="mailto:erin.hardnett.1@vanderbilt.edu?subject=Bachelor%20Sign%20Up%20Error%20Attendee">this email.</a>
          </h6><br>
          <?php
        } else {
          ?>
          <h6 class="form_submission_error">Error in submitting form! Please
            contact Erin at <a href="mailto:erin.hardnett.1@vanderbilt.edu?subject=Bachelor%20Sign%20Up%20Error">this email.</a>
          </h6><br>
          <?php
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Bachelor Sign Up</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/bachelor-signup.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/bachelor-signup.js"></script>
    <script type="text/javascript" src="js/cookies-enable.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="js/require.js"></script>
    <script src="js/aws-sdk-2.804.0.min.js"></script>
    <script type="text/javascript" src="js/upload-image.js"></script>
</head>

<body>
<h2>HeartbreAKA Bachelor Sign Up</h2> <br>
<p>
  On behalf of the Elegant Eta Beta Chapter of Alpha Kappa Alpha Sorority,
  Incorporated, ​you are cordially invited to participate as a bachelor in our
  highly anticipated event​,​ HeartbreAKA​ on February 12, 2021, at 7:08 PM​. As
  someone who has been identified as an ideal candidate for our date auction, we
  would love to have you participate. <br><br>

  HeartbreAKA is our annual fundraiser that seeks to collect ​art supplies as a
  part of our​ 'Celebration of the Arts'​ initiative.​ ​Attendees will dropoff
  different ​art supplies​/shoes, prior to the event, that will equate to an
  amount of AKA Dollars to then bid on bachelors in a ​date auction. <br><br>

  Beginning this year, the bachelors will be announced on our website in the
  days leading up to the event. As you are answering these questions, please
  keep in mind that your answers will show up on the website as written. Upon
  your name being added to the website, you will be authorized to change any
  information that is displayed and all changes will be monitored by the members
  of the chapter. <br><br>

  Your participation would require you to attend our ​1.5-hour program on ​
  February 12, 2021​, at 7:08 PM CST as well as a free, virtual date to
  on February 13, 2021, from 5:00-7:00 PM CST ​with your companion. Details on
  what the date will be sent out to your email at a later date. Please carefully
  look at your calendars​ as a commitment to both
  dates is <strong>mandatory</strong> unless previously communicated.​
  <strong> Due to COVID restrictions, if you can not make this date, please do
    not sign up as we can not guarantee an alternative date for you and the
    winner.</strong><br><br>

  Please RSVP ​on this form by ​Friday, ​January 31st​​ at ​5:00 pm. If you have any
  questions, don't hesitate to ​email me​. We look forward to your participation.
</p>
<br>
<form id="sign_up" method="post" enctype="multipart/form-data">
    <label for="full_name">Full Name</label><br>
    <input type="text" name="full_name" placeholder="i.e. Joe Smith" onchange="changeState()" required><br><br>

    <?php // TODO: Add the pattern to only accept vanderbilt emails here! ?>
    <label for="email">Vanderbilt Email</label><br>
    <input type="email" name="email" placeholder="i.e. joe.smith@vanderbilt.edu" onchange="changeState()" pattern="[a-z0-9._%+-]+@vanderbilt.edu" required>
    <p id="note">NOTE: This email will be used to sign in to the website with.</p><br>

    <label for="major">Major</label><br>
    <input type="text" name="major" placeholder="i.e. Economics" onchange="changeState()" required><br><br>

    <label for="class">Classification</label><br>
    <select class="" name="class" onchange="changeState()" required>
        <option value="select" disabled selected>Select your class standing</option>
        <option value="Freshman">Freshman</option>
        <option value="Sophomore">Sophomore</option>
        <option value="Junior">Junior</option>
        <option value="Senior">Senior</option>
    </select><br><br>

    <label for="hometown_state">Hometown, State</label><br>
    <input type="text" name="hometown_state" placeholder="i.e. Nashville, TN" onchange="changeState()" required><br><br>

    <label for="food">What is your favorite food?</label><br>
    <input class="short_answer" type="text" name="food" onchange="changeState()" required><br><br>

    <label for="hobbies">What are your favorite hobbies?</label>
    <input class="short_answer" type="text" name="hobbies" onchange="changeState()" required><br><br>

    <label for="pet_peeves">What are your biggest pet peeves?</label>
    <input class="short_answer" type="text" name="pet_peeves" onchange="changeState()" required><br><br>

    <label for="dream_date">What is your dream date?</label><br>
    <input class="short_answer" type="text" name="dream_date" onchange="changeState()" required><br><br>

    <label for="uploadImg">Upload a recent picture of yourself</label>
    <input type="file" name="uploadImg" accept="image/*" onchange="changeState()" required>
    <input type="button" id="upload_image" name="upload_image" value="Upload Image" onclick="uploadImage()" disabled>
    <p id="message"></p>

    <input type="submit" name="sign_up" value="Sign Up as Bachelor" id="submit_button" disabled>
</form>

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
<script type="text/javascript" src="js/cookies-enable.js"></script>

</html>
