<?php
require_once("conn.php");
require_once("createflags.php");
$query = "SELECT * FROM aka.bachelors";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
    print_r($result);

} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
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
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <h2>Bachelor Sign Up</h2> <br>
    <form class="" action="bachelor-signup.php" method="post" enctype="multipart/form-data">
      <label for="full_name">Full Name</label><br>
      <input type="text" name="full_name" placeholder="i.e. Joe Smith" required><br><br>

      <label for="email">Vanderbilt Email</label><br>
      <input type="email" name="email" placeholder="i.e. joe.smith@vanderbilt.edu" pattern=".+@vanderbilt.edu" required>
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
    if (isset($_POST['sign_up'])) {
      $full_name = $_POST['full_name'];
      $email = $_POST['email'];
      $major = $_POST['major'];
      $class = $_POST['class'];
      $hometown_state = $_POST['hometown_state'];
      $food = $_POST['food'];
      $hobbies = $_POST['hobbies'];
      $pet_peeves = $_POST['pet_peeves'];
      $dream_date = $_POST['dream_date'];
      $image = basename($_FILES['uploadImg']["name"]);
      $tmp_image = $_FILES['uploadImg']['tmp_name'];
      require_once("uploadImg.php");
      $biography = array(
        "Hometown, State" => $hometown_state,
        "What is your favorite food?" => $food,
        "What are your favorite hobbies?" => $hobbies,
        "What are your biggest pet peeves?" => $pet_peeves,
        "What is your dream date?" => $dream_date
      );
      $biographyStr = implode('||', array_map(
                  function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                  $biography,
                  array_keys($biography)
                ));
      $uploadedImageLocation = "images/bachelors/" . $email . "/" . $_FILES['uploadImg']['name'];
      // print_r($full_name);
      // print_r($email);
      // print_r($major);
      // print_r($class);
      // print_r($biographyStr);
      // print_r($uploadedImageLocation);
      $add_bachelor = "INSERT INTO aka.bachelors (fullName, email, class, major, biography, photoUrl, maxBid, auctionStatus, addedBy, auction_order_id)
                       VALUES (:fullName, :email, :class, :major, :biography, :photoUrl, 0.00, 0, 0, 0)";

      try {
         $add_bachelor_prepared_stmt = $dbo->prepare($add_bachelor);
         $add_bachelor_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->bindValue(':biography', $biographyStr, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->bindValue(':photoUrl', $uploadedImageLocation, PDO::PARAM_STR);
         $add_bachelor_prepared_stmt->execute();

      } catch (PDOException $ex) { // Error in database processing.
         echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
      }
      ?>
      Form submitted successfully!
      <?php

    }
    include_once("overlay.php");
    ?>
  </body>

</html>
