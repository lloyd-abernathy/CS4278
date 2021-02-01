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
if ($admin_flag) {
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
    if (isset($_POST['add_admin'])) {
        $isSuccess = (bool)false;
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $check_admin_email = "SELECT * FROM aka.admins WHERE email = :email";

        try {
            $check_admin_email_prepared_stmt = $dbo->prepare($check_admin_email);
            $check_admin_email_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $check_admin_email_prepared_stmt->execute();
            $check_admin_email_result = $check_admin_email_prepared_stmt->fetchAll();
        } catch (PDOException $ex) {

        }
        if ($check_admin_email_prepared_stmt->rowCount() == 0) {
          $insert_to_admin = "INSERT INTO admins (fullName, email)
                              VALUES (:fullName, :email)";
          try {
              $insert_to_admin_prepared_stmt = $dbo->prepare($insert_to_admin);
              $insert_to_admin_prepared_stmt->bindValue(':fullName', $full_name, PDO::PARAM_STR);
              $insert_to_admin_prepared_stmt->bindValue(':email', $email, PDO::PARAM_STR);
              $insert_to_admin_prepared_stmt->execute();
              $isSuccess = (bool)true;
          } catch (PDOException $ex) {
              echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
          }
        }

        if ($isSuccess) {
          ?>
          <h6 class="form_submission_successful">Successfully added admin!
          </h6><br>
          <?php
        } else {
          ?>
          <h6 class="form_submission_error">Admin already exists!</h6><br>
          <?php
        }
    }
    ?>
    <h2>Delete Admins</h2><br><br>
    <?php
    if (isset($result) && $prepared_stmt->rowCount() > 0) {
        ?>
        <form class="" action="add-delete-admins.php" method="post">
            <select class="" name="delete">
                <!-- <option value="select" disabled selected>Select Admin to Delete</option> -->
                <?php
                foreach ($result as $row) {
                    ?>
                    <option value="<? $row['adminId'] ?>"><?php echo $row['fullName']; ?></option>
                    <?php
                }
                ?>
            </select>
            <input type="submit" name="delete_admin" value="Delete Admin">
        </form>
        <?php
    }

    if (isset($_POST['delete_admin'])) {
        $admin_to_delete = $_POST['delete'];
        $foreign_checks_zero = "SET FOREIGN_KEY_CHECKS = 0";
        $delete_admin = "DELETE FROM aka.admins WHERE adminId = :id";
        try {
            $foreign_checks_zero_prepared_stmt = $dbo->prepare($foreign_checks_zero);
            $foreign_checks_zero_prepared_stmt->execute();

            $delete_admin_prepared_stmt = $dbo->prepare($delete_admin);
            $delete_admin_prepared_stmt->bindValue(':id', intval($admin_to_delete), PDO::PARAM_INT);
            $delete_admin_prepared_stmt->execute();
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
<script type="text/javascript" src="js/cookies-enable.js"></script>

</body>
</html>
