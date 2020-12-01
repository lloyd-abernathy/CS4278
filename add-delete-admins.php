<?php

require_once("conn.php");
require_once("createflags.php");

$query = "SELECT * FROM aka.admins WHERE adminId != :adminId";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':adminId', $login_result['id'], PDO::PARAM_INT);
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
    <title></title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/add-delete-admins.css">
    <script type="text/javascript" src="js/add-delete-admins.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
  </head>
  <body>
    <?php
    include_once("header.php");
    if($admin_flag) {
      ?>
      <h2>Add Admins</h2><br><br>
      <form class="" action="add-delete-admins.php" method="post">
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name">
        <label for="email">Email</label>
        <input type="email" name="email">
        <input type="submit" name="add_admin" value="Add New Admin">
      </form><br>
      <?php
      if ($_POST['add_admin']) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];

        $insert_to_admin = "INSERT INTO admins (fullName, email)
                            VALUES (:fullName, :email)";
        try {
          $insert_to_admin_prepared_stmt = $dbo->prepare($insert_to_admin);
          $insert_to_admin_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
          $insert_to_admin_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
          $insert_to_admin_prepared_stmt->execute();
        } catch (PDOException $ex) {
          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

      }
       ?>
      <h2>Delete Admins</h2><br><br>
      <?php
      if ($result && $prepared_stmt->rowCount() > 0) {
        ?>
        <form class="" action="add-delete-admins.php" method="post">
          <select class="" name="delete">
            <!-- <option value="select" disabled selected>Select Admin to Delete</option> -->
            <?php
            foreach ($result as $row) {
              ?>
              <option value="<? echo $row['adminId']; ?>"><?php echo $row['fullName']; ?></option>
              <?php
            }
             ?>
          </select>
          <input type="submit" name="delete_admin" value="Delete Admin">
        </form>
        <?php
      }

      if ($_POST['delete_admin']) {
        $admin_to_delete = $_POST['delete'];

        $delete_admin = "DELETE FROM aka.admins WHERE adminId = :id";
        try {
          $delete_admin_prepared_stmt = $dbo->prepare($delete_admin);
          $delete_admin_prepared_stmt->bindValue(':id', $admin_to_delete, PDO::PARAM_INT);
          $delete_admin_prepared_stmt->execute();
          print_r($delete_admin_prepared_stmt->errorInfo());
        } catch (PDOException $ex) {
          echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }
      }
    } else if ($bachelor_flag || $attendee_flag) {
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
     <?php include_once("overlay.php"); ?>
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
</html>
