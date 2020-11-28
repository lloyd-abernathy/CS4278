<?php
$signup_dir = "images/bachelors/" . $email . "/";
$uploadOK = 1;
if (!is_dir($signup_dir)) {
  mkdir("images/bachelors/" . $email . "/");
}

$target_file = $signup_dir . $image;
$uploadOK = 1;

$check = getimagesize($tmp_image);
  if($check !== false) {
    $uploadOK = 1;
  } else {
    $uploadOK = 0;
  }

if ($uploadOK == 1) {
  if (move_uploaded_file($tmp_image, $target_file)) {
    ?>
    Image uploaded successfully!
    <?php
  } else {
    $uploadOK = 0;
    ?>
    Image was not uploaded successfully.
    <?php
  }
} else {
  $uploadOK = 0;
  ?>
  Image was not uploaded successfully since it is not the right type.
  <?php
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
