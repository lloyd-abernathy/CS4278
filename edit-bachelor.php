<?php
  require_once("conn.php");
  require_once("createflags.php");
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
   </head>
   <body>
     <?php include_once("header.php"); ?>

     <?php
     if ($bachelor_flag) {
       ?>
       <h2>Edit Your Bachelor Profile</h2>
       <p>Fill out this form with any changes you would like to make to your existing
          profile. Upon submitting, your changes will be reviewed and made available
          when they have been approved.</p>
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

            <label for="uploadImg">If you want, you can upload a new picture of yourself!</label>
            <input type="file" name="uploadNewImg" accept="image/*"><br><br>

            <input type="submit" name="submit_changes" value="Submit Changes">
          </form>
          <?php
          if ($_POST['submit_changes']) {
            $full_name = $_POST['full_name'];
            $major = $_POST['major'];
            $class = $_POST['class'];
            $biography = $_POST['biography'];
            // $bioArr = array(
            //   "Hometown, State" => $biography[0],
            //   "What is your favorite food?" => $biography[1],
            //   "What are your favorite hobbies?" => $biography[2],
            //   "What are your biggest pet peeves?" => $biography[3],
            //   "What is your dream date?" => $biography[4]
            // );
            $bioArr = array();
            for ($x = 0; $x < count($biography); $x = $x + 2) {
              $bioArr[$biography[$x]] = $biography[$x + 1];
            }
            $bioString = implode('||', array_map(
                        function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                        $bioArr,
                        array_keys($bioArr)
                      ));
            print_r($bioArr);
            print_r($bioString);
            $image = basename($_FILES['uploadNewImg']["name"]);
            $tmp_image = $_FILES['uploadNewImg']['tmp_name'];
            require_once("uploadImg.php");
            if ($_FILES['uploadNewImg']['size'] == 0 && $_FILES['uploadNewImg']['error'] == 0) {
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
                  print_r("No image: " . $update_bachelor_without_image_prepared_stmt->errorInfo());
               } catch (PDOException $ex) { // Error in database processing.
                   echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
               }

            } else {

              $uploadedImageLocation = "images/bachelors/" . $login_result['email'] . "/" . $_FILES['uploadNewImg']["name"];
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
                 print_r("Image: " . $update_bachelor_with_image_prepared_stmt->errorInfo());
              } catch (PDOException $ex) { // Error in database processing.
                  echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
              }

            }
          }
           ?>
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
   </body>
 </html>
