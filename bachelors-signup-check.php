<?php
function uploadImg($email, $image, $tmp_image) {
  $targer_dir = mkdir("images/bachelors/" . $email . "/");
  $target_file = $targer_dir . $image;
  $uploadOK = 1;

  if (is_dir($target_dir)) {
    $uploadOK = 0;
    echo "Your application has been approved! Please log in to edit your profile as needed.";
  }

  if ($uploadOK == 1) {
    if (move_uploaded_file($tmp_image, $target_file)) {
      echo "Your application has been submitted for approval!";
    } else {
      echo "Sorry, there was an error with uploading your file. Please choose a JPG, JPEG, or PNG file.";
    }
  }
}

function checkBachelorDatabase($email) {
  $check_bachelors = "SELECT * FROM aka.bachelors WHERE email = :email";

  try {
    $check_bachelors_prepared_stmt = $dbo->prepare($check_bachelors);
    $check_bachelors_prepared_stmt->execute();
    $check_bachelors_result = $check_bachelors_prepared_stmt->fetchAll();
  } catch (PDOException $ex) {
    echo $sql . "<br>" . $error->getMessage();
  }

  if ($check_bachelors_result && $check_bachelors_prepared_stmt->rowCount() > 0) {
    echo "Your application has been submitted! Please try logging in to see if your bachelor profile can be edited.";
    return false;
  }

  return true;
}
 ?>
