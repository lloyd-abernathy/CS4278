<?php

require_once("conn.php");
require_once("createflags.php");

$to_do_query = "SELECT * FROM aka.notifications WHERE notificationFlag = 0";
$done_query = "SELECT * FROM aka.notifications WHERE notificationFlag = 1 ORDER BY notificationId DESC LIMIT 30";

try {
    $to_do_prepared_stmt = $dbo->prepare($to_do_query);
    $to_do_prepared_stmt->execute();
    $to_do_result = $to_do_prepared_stmt->fetchAll();

    $done_prepared_stmt = $dbo->prepare($done_query);
    $done_prepared_stmt->execute();
    $done_result = $done_prepared_stmt->fetchAll();

} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

if (isset($_POST['mark_completed'])) {
    $isSuccess = (bool)false;
    $notification_ids = $_POST['notificationId'];
    for ($x = 0; $x < count($notification_ids); $x++) {
        $notification_id = $notification_ids[$x];
        $type = $_POST['type-' . $notification_id];
        $message = explode(",", $_POST['message-' . $notification_id]);
        $messageArr = array();
        foreach ($message as $str) {
            $attributes = explode(": ", $str);
            $messageArr[$attributes[0]] = $attributes[1];
        }

        $approved = $_POST['approved-' . $notification_id];

        $name_of_attendee = $messageArr[' Name'];
        $email_of_attendee = $messageArr[' Email'];

        $is_attendee = false;

        $find_attendee_info = "SELECT * FROM aka.attendees WHERE email = :email";

        try {
            $find_attendee_info_prepared_stmt = $dbo->prepare($find_attendee_info);
            $find_attendee_info_prepared_stmt->bindValue(':email', $email_of_attendee, PDO::PARAM_STR);
            $find_attendee_info_prepared_stmt->execute();
            $find_attendee_info_result = $find_attendee_info_prepared_stmt->fetchAll();
        } catch (PDOException $ex) {
            echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
        }

        if (isset($find_attendee_info_result) && $find_attendee_info_prepared_stmt->rowCount() == 1) {
            $is_attendee = true;
        }

        if ($type == "Monetary Donation") {
            if ($approved == "Approve") {
                $donation_amount = $messageArr[' Amount ($)'];
                $bank_monetary = $donation_amount * 100;
                if ($is_attendee) {
                    $attendee_id = $find_attendee_info_result[0]['attendeeId'];
                    $update_attendee_monetary = "UPDATE aka.attendees
                              SET totalDonations = totalDonations + :donation, accountBalance = accountBalance + :bank
                              WHERE attendeeId = :attendee";
                    try {
                        $update_attendee_monetary_prepared_stmt = $dbo->prepare($update_attendee_monetary);
                        $update_attendee_monetary_prepared_stmt->bindValue(':attendee', $attendee_id, PDO::PARAM_INT);
                        $update_attendee_monetary_prepared_stmt->bindValue(':donation', $donation_amount, PDO::PARAM_INT);
                        $update_attendee_monetary_prepared_stmt->bindValue(':bank', $bank_monetary, PDO::PARAM_INT);
                        $update_attendee_monetary_prepared_stmt->execute();
                    } catch (PDOException $ex) {
                        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                    }

                }
                $update_notification_monetary_approved = "UPDATE aka.notifications
                                SET notificationFlag = 1, notificationApproved = 1
                                WHERE notificationId = :notification";
                try {
                    $update_notification_monetary_approved_prepared_stmt = $dbo->prepare($update_notification_monetary_approved);
                    $update_notification_monetary_approved_prepared_stmt->bindValue(':notification', $notification_id, PDO::PARAM_INT);
                    $update_notification_monetary_approved_prepared_stmt->execute();
                } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
            } else {
                $update_notification_monetary_denied = "UPDATE aka.notifications
                                SET notificationFlag = 1, notificationApproved = 0
                                WHERE notificationId = :notification";
                try {
                    $update_notification_monetary_denied_prepared_stmt = $dbo->prepare($update_notification_monetary_denied);
                    $update_notification_monetary_denied_prepared_stmt->bindValue(':notification', $notification_id, PDO::PARAM_INT);
                    $update_notification_monetary_denied_prepared_stmt->execute();
                } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
            }
            $isSuccess = (bool)true;
        } else if ($type == "Dropbox Donation") {
            if ($approved == "Approve") {
                $bank_dropbox = $messageArr[' AKA Dollars'];
                if ($is_attendee) {
                    $attendee_id = $find_attendee_info_result[0]['attendeeId'];
                    $update_attendee_dropbox = "UPDATE aka.attendees
                              SET accountBalance = accountBalance + :bank
                              WHERE attendeeId = :attendee";
                    try {
                        $update_attendee_dropbox_prepared_stmt = $dbo->prepare($update_attendee_dropbox);
                        $update_attendee_dropbox_prepared_stmt->bindValue(':attendee', $attendee_id, PDO::PARAM_INT);
                        $update_attendee_dropbox_prepared_stmt->bindValue(':bank', $bank_dropbox, PDO::PARAM_INT);
                        $update_attendee_dropbox_prepared_stmt->execute();
                    } catch (PDOException $ex) {
                        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                    }

                }
                $update_notification_dropbox_approved = "UPDATE aka.notifications
                                SET notificationFlag = 1, notificationApproved = 1
                                WHERE notificationId = :notification";
                try {
                    $update_notification_dropbox_approved_prepared_stmt = $dbo->prepare($update_notification_dropbox_approved);
                    $update_notification_dropbox_approved_prepared_stmt->bindValue(':notification', $notification_id, PDO::PARAM_INT);
                    $update_notification_dropbox_approved_prepared_stmt->execute();
                } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
            } else {
                $update_notification_dropbox_denied = "UPDATE aka.notifications
                                SET notificationFlag = 1, notificationApproved = 0
                                WHERE notificationId = :notification";
                try {
                    $update_notification_dropbox_denied_prepared_stmt = $dbo->prepare($update_notification_dropbox_denied);
                    $update_notification_dropbox_denied_prepared_stmt->bindValue(':notification', $notification_id, PDO::PARAM_INT);
                    $update_notification_dropbox_denied_prepared_stmt->execute();
                } catch (PDOException $ex) {
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                }
            }
            $isSuccess = (bool)true;
        }
    }
    if ($isSuccess) {
      ?>
      <h6 class="form_submission_successful">Tasks have been marked accordingly!
        Do not resubmit form! Enter page again to see results.
      </h6><br>
      <?php
    } else {
      ?>
      <h6 class="form_submission_error">Tasks were not marked correctly! Do not
        resubmit form! Enter page again to see the remaining donations to
        approve. </h6><br>
      <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Donations List</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/donations-admin-list.css">
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/donations-admin-list.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
</head>
<body>

<?php
include_once("header.php");
if ($admin_flag) {

?>

<div class="donations_admin_list_info">
    <h2>Donations to Review</h2>
    <br>
    <form class="" action="donations-admin-list.php" method="post" onsubmit="window.location.reload(); window.location.reload();">
        <?php
        if (isset($to_do_result) && $to_do_prepared_stmt->rowCount() > 0) { ?>
        <table class="tasks">
            <thead>
            <th>&nbsp;</th>
            <th>Message</th>
            <th>Approved?</th>
            </thead>
            <tbody>
            <?php
            foreach ($to_do_result as $to_do) {
                ?>
                <tr>
                    <td>
                        <h4><?php echo $to_do["notificationId"]; ?></h4>
                        <input type="hidden" name="notificationId[]"
                               value="<?php echo $to_do["notificationId"]; ?>">
                        <input type="hidden"
                               name="<?php echo "type-" . $to_do["notificationId"]; ?>"
                               value="<?= $to_do["notificationType"] ?>">
                    </td>
                    <td>
                        <strong>Subject: </strong> <?php echo $to_do["notificationSubject"]; ?>
                        <br><br>
                        <?php
                        if ($to_do["notificationType"] == "Dropbox Donation") {
                            ?>
                            <h4>Message From: </h4>
                            <?php
                        } else {
                            ?>
                            <h4>Message: </h4>
                            <?php
                        }
                        ?>
                        <?php
                        $message_received = explode(",", $to_do["notificationMessage"]);
                        if ($to_do["notificationType"] == "Dropbox Donation") {
                            foreach ($message_received as $str) {
                                $attribute = explode(":", $str);
                                $attribute_check = str_replace(" ", "", $attribute[0]);
                                if ($attribute_check == "Donations") {
                                    ?>
                                    <br>
                                    <h4>Donations:</h4>
                                    <?php
                                    $donations = explode("||", $attribute[1]);
                                    for ($y = 0; $y < count($donations); $y++) {
                                        $donate = explode("=", $donations[$y]);
                                        ?>
                                        <p>
                                            <?php echo "Number of " . $donate[0] . ": " . substr($donate[1], 1, -1); ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p>
                                        <u><?php echo $attribute[0]; ?></u>
                                        <?php echo ":" . $attribute[1]; ?>
                                    </p>
                                    <?php
                                }
                            }
                        } else {
                            foreach ($message_received as $str) {
                                $other_attribute = explode(":", $str);
                                ?>
                                <p>
                                    <u><?php echo $other_attribute[0]; ?></u>
                                    <?php echo ":" . $other_attribute[1]; ?>
                                </p>
                                <?php
                            }
                        }

                        ?>
                        <input type="hidden"
                               name="<?php echo "message-" . $to_do["notificationId"]; ?>"
                               value="<?php echo $to_do["notificationMessage"]; ?>">
                    </td>
                    <td>
                        <input type="radio"
                               name="<?php echo "approved-" . $to_do["notificationId"]; ?>"
                               value="Approve">
                        <label>Approve</label><br>
                        <input type="radio"
                               name="<?php echo "approved-" . $to_do["notificationId"]; ?>"
                               value="Deny">
                        <label>Deny</label>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>


        <input type="submit" name="mark_completed" value="Mark Tasks Completed">
    </form>
    <?php
    } else { ?>

        <h4 class="no_tasks">NO TASKS TO COMPLETE!</h4>
        <?php
    } ?>
    <?php

    ?>
    <h2>Reviewed Donations</h2>
    <br>
    <?php
    if (isset($done_result) && $done_prepared_stmt->rowCount() > 0) { ?>
        <table class="tasks">
            <thead>
            <th>&nbsp;</th>
            <th>Message</th>
            <th>Approved?</th>
            </thead>
            <tbody>
            <?php
            foreach ($done_result as $done) {
                ?>
                <tr>
                    <td>
                      <h4><?php echo $done["notificationId"]; ?></h4>
                    </td>
                    <td>
                        <strong>Subject: </strong> <?php echo $done["notificationSubject"]; ?><br>
                        <?php
                        $message_done_recieved = explode(",", $done["notificationMessage"]);
                        if ($done['notificationType'] == "Dropbox Donation") {
                            ?>
                            <h4>Message From: </h4>
                            <?php
                            foreach ($message_done_recieved as $done_str) {
                                $done_attribute = explode(":", $done_str);
                                $done_attribute_check = str_replace(" ", "", $done_attribute[0]);
                                if ($done_attribute_check == "Donations") {
                                    ?>
                                    <br>
                                    <h4>Donations:</h4>
                                    <?php
                                    $done_donations = explode("||", $done_attribute[1]);
                                    for ($y = 0; $y < count($done_donations); $y++) {
                                        $done_donate = explode("=", $done_donations[$y]);
                                        ?>
                                        <p>
                                            <?php echo "Number of " . $done_donate[0] . ": " . substr($done_donate[1], 1, -1); ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p>
                                        <u><?php echo $done_attribute[0]; ?></u>
                                        <?php echo ":" . $done_attribute[1]; ?>
                                    </p>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <h4>Message: </h4>
                            <?php
                            foreach ($message_done_recieved as $done_str) {
                                $other_done_attribute = explode(":", $done_str);
                                ?>
                                <p>
                                    <u><?php echo $other_done_attribute[0]; ?></u>
                                    <?php echo ":" . $other_done_attribute[1]; ?>
                                </p>
                                <?php
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($done['notificationApproved'] == 1) {
                            ?>
                            <strong>Approved!</strong>
                            <?php
                        } else {
                            ?>
                            <strong>Denied.</strong>
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    } else { ?>
        <h4 class="no_tasks">NO TASKS HAVE BEEN COMPLETED!</h4>
        <?php
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
</div>

<?php include_once("overlay.php"); ?>

</div>

</div>

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
