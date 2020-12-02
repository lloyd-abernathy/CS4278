<?php

if (isset($image) && isset($tmp_image)) {
  $signup_dir = "images/bachelors/" . $email . "/";
  $uploadOK = 1;
  if (!is_dir($signup_dir)) {
    mkdir("images/bachelors/" . $email . "/");
  }
  $target_file = $signup_dir . $image;
  $uploadOK = 1;

  if ($uploadOK == 1) {
    if (move_uploaded_file($tmp_image, $target_file)) {
      ?>
      <h6 class="form_submission_successful">Image Uploaded Successfully!</h6><br>
      <?php
    } else {
      $uploadOK = 0;

      ?>
      <h6 class="form_submission_error">Your image was not uploaded correctly
        Please contact Erin with <a href="mailto:erin.hardnett.1@vanderbilt.edu?subject=Bachelor%20Sign%20Up%20Error%20Image">this email.</a>
      </h6><br>
      <?php

    }
  } else {
    $uploadOK = 0;

    ?>
    <h6 class="form_submission_error">Image is not of the right type (JPEG, JPG, PNG). Do not resubmit!
      Please contact Erin with <a href="mailto:erin.hardnett.1@vanderbilt.edu?subject=Bachelor%20Sign%20Up%20Error%20Image%20Wrong%20Type">this email.</a>
    </h6><br>
    <?php
  }
}

// function checkBachelorDatabase($email) {
//   $check_bachelors = "SELECT * FROM aka.bachelors WHERE email = :email";
//
//   try {
//     $check_bachelors_prepared_stmt = $dbo->prepare($check_bachelors);
//     $check_bachelors_prepared_stmt->execute();
//     $check_bachelors_result = $check_bachelors_prepared_stmt->fetchAll();
//   } catch (PDOException $ex) {
//     echo $sql . "<br>" . $error->getMessage();
//   }
//
//   if ($check_bachelors_result && $check_bachelors_prepared_stmt->rowCount() > 0) {
//     echo "Your application has been submitted! Please try logging in to see if your bachelor profile can be edited.";
//     return false;
//   }
//
//   return true;
// }
 ?>
