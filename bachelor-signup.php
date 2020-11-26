<?php
require_once("conn.php");
require_once("bachelors-signup-check.php");
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
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <h2>Bachelor Sign Up</h2> <br>
    <form class="" action="bachelor-signup.php" method="post" enctype="multipart/form-data">
      <label for="first_name">First Name</label><br>
      <input type="text" name="first_name" placeholder="i.e. Joe" required><br><br>

      <label for="last_name">Last Name</label><br>
      <input type="text" name="last_name" placeholder="i.e. Smith" required><br><br>

      <label for="email">Vanderbilt Email</label><br>
      <input type="email" name="email" placeholder="i.e. joe.smith@vanderbilt.edu" required>
      <p id="note">NOTE: This email will be used to sign in to the website with.</p><br>

      <label for="major">Major</label><br>
      <input type="text" name="major" placeholder="i.e. Economics" required><br><br>

      <label for="class">Classification</label><br>
      <select class="" name="class" required>
        <option value="select" disabled selected>Select your class standing</option>
        <option value="Freshman">Freshman</option>
        <option value="Sophomore">Sophomore</option>
        <option value="Junior">Junior</option>
        <option value="Senior">Senior</option>
      </select><br><br>

      <label for="hometown_state">Hometown, State</label><br>
      <input type="text" name="hometown_state" placeholder="i.e. Nashville, TN" required><br><br>

      <label for="food">What is your favorite food?</label><br>
      <input class="short_answer" type="text" name="food" required><br><br>

      <label for="hobbies">What are your favorite hobbies?</label>
      <input class="short_answer" type="text" name="hobbies" required><br><br>

      <label for="pet_peeves">What are your biggest pet peeves?</label>
      <input class="short_answer" type="text" name="pet_peeves" required><br><br>

      <label for="dream_date">What is your dream date?</label><br>
      <input class="short_answer" type="text" name="dream_date" required><br><br>

      <label for="uploadImg">Upload a recent picture of yourself</label>
      <input type="file" name="uploadImg" accept="image/*" required><br><br>

      <input type="submit" name="sign_up" value="Sign Up as Bachelor">
    </form>
    <?php
    include_once("overlay.php");
    if (isset($_POST['sign_up'])) {
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $email = $_POST['email'];
      if (checkDatabase($email)) {
        $major = $_POST['major'];
        $class = $_POST['class'];
        $hometown_state = $_POST['hometown_state'];
        $food = $_POST['food'];
        $hobbies = $_POST['hobbies'];
        $pet_peeves = $_POST['pet_peeves'];
        $dream_date = $_POST['dream_date'];
        $image = basename($_FILES['uploadImg']["name"]);
        $tmp_image = $_FILES['uploadImg']['tmp_name'];
        uploadImg($email, $image, $tmp_image);
        ?>
        Successfully entered!
        <?php
      } else {
        ?>
        Application was not submitted for approval!
        <?php
      }
      print_r($_FILES);
    }
      ?>
  </body>
</html>
