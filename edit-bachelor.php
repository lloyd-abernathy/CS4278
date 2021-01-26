<?php
  require_once("conn.php");
  require_once("createflags.php");
  if ($bachelor_flag && isset($_POST['email'])) {
    $isSuccess = (bool)false;
    $full_name = $_POST['full_name'];
    $major = $_POST['major'];
    $class = $_POST['class'];
    $biography = $_POST['biography'];
    $bioArr = array();
    for ($x = 0; $x < count($biography); $x = $x + 2) {
      $bioArr[$biography[$x]] = $biography[$x + 1];
    }
    $bioString = implode('||', array_map(
                function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                $bioArr,
                array_keys($bioArr)
              ));
    // Update photo in the database
    if (isset($_COOKIE['newPhoto']) && isset($_POST['uploadNewImg'])) {
      $uploadedImageLocation = $_COOKIE['newPhoto'];
      $update_bachelor_with_image = "UPDATE aka.bachelors
                                     SET fullName = :fullName, major = :major, class = :class, biography = :biography, photoUrl = :photoUrl, addedBy = NULL
                                     WHERE bachelorId = :id";
     try {
         $update_bachelor_with_image_prepared_stmt = $dbo->prepare($update_bachelor_with_image);
         $update_bachelor_with_image_prepared_stmt->bindValue(':id', $login_result['id'], PDO::PARAM_INT);
         $update_bachelor_with_image_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
         $update_bachelor_with_image_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
         $update_bachelor_with_image_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
         $update_bachelor_with_image_prepared_stmt->bindValue(':biography', $bioString, PDO::PARAM_STR);
         $update_bachelor_with_image_prepared_stmt->bindValue(':photoUrl', $uploadedImageLocation, PDO::PARAM_STR);
         $update_bachelor_with_image_prepared_stmt->execute();
         $isSuccess = (bool)true;
      } catch (PDOException $ex) { // Error in database processing.
          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
      }
    // Update without photo in the database
    } else {
      $update_bachelor_without_image = "UPDATE aka.bachelors
                                        SET fullName = :fullName, major = :major, class = :class, biography = :biography, addedBy = NULL
                                        WHERE bachelorId = :id";
      try {
          $update_bachelor_without_image_prepared_stmt = $dbo->prepare($update_bachelor_without_image);
          $update_bachelor_without_image_prepared_stmt->bindValue(':id', $login_result['id'], PDO::PARAM_INT);
          $update_bachelor_without_image_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
          $update_bachelor_without_image_prepared_stmt->bindValue(':major', $major, PDO::PARAM_STR);
          $update_bachelor_without_image_prepared_stmt->bindValue(':class', $class, PDO::PARAM_STR);
          $update_bachelor_without_image_prepared_stmt->bindValue(':biography', $bioString, PDO::PARAM_STR);
          $update_bachelor_without_image_prepared_stmt->execute();
          $isSuccess = (bool)true;
       } catch (PDOException $ex) { // Error in database processing.
           echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
       }
    }

    if ($isSuccess) {
      ?>
      <h6 class="form_submission_successful">Form submitted successfully!
        View account <a href="account.php">here</a> to see changes.
      </h6><br>
      <?php
    } else {
      ?>
      <h6 class="form_submission_error">Form was not submitted successfully!
          Please see if there are any errors in your form submission. If not,
          please contact Erin at
          <a href="mailto:erin.hardnett.1@vanderbilt.edu?subject=Bachelor%20Edit%20Profile%20Error%20"> this email</a>.
        </h6><br>
      <?php
    }
    }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Edit Profile</title>
     <link rel="stylesheet"
           href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="css/edit-bachelor.css">
     <link rel="stylesheet" href="css/master.css">
     <script src="https://apis.google.com/js/platform.js"></script>
     <script type="text/javascript" src="js/google-login.js"></script>
     <script type="text/javascript" src="js/edit-bachelor.js"></script>
     <script src="js/require.js"></script>
     <script src="js/aws-sdk-2.804.0.min.js"></script>
     <script type="text/javascript" src="js/edit-upload-image.js"></script>
   </head>
   <body>
     <?php include_once("header.php"); ?>

     <?php
     if ($bachelor_flag) {
       ?>
       <h2>Edit Your Bachelor Profile</h2>
       <p>Fill out this form with any changes you would like to make to your existing
          profile. Upon submitting, your changes will be reviewed and made available
          when they have been approved. Your changes will be immediately available
          on your account <a href="account.php">here</a>.
          <strong>You will only be able to submit changes one at a time! The chapter will
          approve your changes by the end of the day.</strong>
        </p><br>
          <form class="" action="edit-bachelor.php" method="post" enctype="multipart/form-data">
            <label for="full_name">Full Name</label><br>
            <input type="text" name="full_name" value="<?php echo $login_result['fullName']; ?>"required><br><br>

            <label for="email">Vanderbilt Email</label><br>
            <input type="email" name="email" value="<?php echo $login_result['email']; ?>" pattern=".+@vanderbilt.edu" required readonly>
            <p id="note">NOTE: This field cannot be edited</p><br>

            <label for="major">Major</label><br>
            <input type="text" name="major" value="<?php echo $login_result['major']; ?>" required><br><br>

            <label for="class">Classification</label><br>
            <input id="class_input" type="text" name="class" value="<?php echo $login_result['class']; ?>" required>
            <p id="note">NOTE: If you would like to edit this field, then click this button below:</p>
            <select id="class_select" class="" name="class" onchange="disableInput()"required>
              <option value="select" disabled selected>Select your class standing</option>
              <option value="Freshman">Freshman</option>
              <option value="Sophomore">Sophomore</option>
              <option value="Junior">Junior</option>
              <option value="Senior">Senior</option>
            </select><br><br>
            <?php
            $bachelorBiographyArr = explode("||", $login_result['biography']);
            foreach ($bachelorBiographyArr as $str) {
              $question = explode("=", $str);
              ?>
              <label for="biography[]"><?php echo $question[0]; ?></label><br>
              <input type="hidden" name="biography[]" value="<?php echo $question[0]; ?>"><br>
              <input type="text" name="biography[]" value="<?php echo substr($question[1], 1, -1); ?>" required><br><br>
              <?php
            }
             ?>
            <label>Current Picture</label><br>
            <img src="<?php echo $login_result['photoUrl']; ?>" alt="" style="width:50%"><br><br>

            <label for="uploadNewImg">Do you want to upload a new photo?</label><br>
            <input type="radio" name="yes" value="Yes">
            <input type="radio" name="no" value="No" checked>
            <input type="file" name="uploadNewImg" accept="image/*"><br><br>
            <input type="button" name="upload_image" value="Upload New Image" onclick="uploadImage()" disabled>
            <p id="message"></p>
            <input type="submit" name="submit_changes" value="Submit Changes">
          </form>
       <?php
     } else if ($admin_flag || $attendee_flag) {
       ?>
       <h4>Restricted Access</h4>
       <p>You do not have access to this page.</p>
       <?php
     } else {
       ?>
       <h4>Sign in Needed</h4>
       <p>Please sign in from the navigation bar to view this page.</p>
       <?php
     }
      ?>
     <?php include_once("overlay.php") ?>
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
     <script type="text/javascript" src="js/cookies-enable.js"></script>
     
   </body>
 </html>
