<?php

require_once("conn.php");

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/master.css">
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <meta name="google-signin-client_id" content="171078891411-7i5ga9cttdoa4u7leqm36eaa013ojj94.apps.googleusercontent.com">
</head>
<body>

<?php include_once("header.php"); ?>
<?php include_once("overlay.php"); ?>

</div>

<div class="login_info">
    <h3>Login To Your Account</h3>
    <br>
    <form class="login_google" action="login.php" method="post">
        <div id="login_google"></div>
    </form>
    <!-- <form class="" action="index.html" method="post">
        <button class="login" id="login_facebook" type="button" name="button"><img class="sign_in_icon" id="facebook_icon" src="https://www.flaticon.com/svg/static/icons/svg/124/124010.svg" alt="facebook_icon"> Login with Facebook</button>
    </form>
    <h3>Sign Up</h3>
    <br>
    <form class="" action="index.html" method="post">
        <button class="sign_up" id="join_google" type="button" name="button"><img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="google_icon"> Join with Google</button>
    </form>
    <form class="" action="index.html" method="post">
        <button class="sign_up" id="join_facebook" type="button" name="button"><img class="sign_in_icon" id="facebook_icon" src="https://www.flaticon.com/svg/static/icons/svg/124/124010.svg" alt="facebook_icon"> Join with Facebook</button>
    </form> -->
</div>



<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var i;

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
</script>

<?php
  require_once("createflags.php");
  if (isset($_COOKIE['email']) && isset($_COOKIE['fullName'])) {
    if (!$admin_flag && !$bachelor_flag && !$attendee_flag) {
      $full_name = $_COOKIE["fullName"];
      $email = $_COOKIE["email"];
       $insert_attendee = "INSERT INTO attendees(email, fullName, accountBalance, totalDonations, auctionWon)
                           VALUES (:email, :fullName, 0.00, 0.00, 0)";
       try {
         $insert_attendee_prepared_stmt = $dbo->prepare($insert_attendee);
         $insert_attendee_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
         $insert_attendee_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
         $insert_attendee_prepared_stmt->execute();
       } catch (PDOException $ex) {
         echo $sql . "<br>" . $error->getMessage();
       }
       $attendee_flag = (bool)true;

     }
     ?>
     <h6 class="form_submission_successful">Login Successful!
     </h6><br>
     <script type="text/javascript">
       window.location.href = "index.html";
     </script>
     <?php
  }
?>

<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script>startApp();</script>
<script type="text/javascript" src="js/cookies-enable.js"></script>

</body>
</html>
