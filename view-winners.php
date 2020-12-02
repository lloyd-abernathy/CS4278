<?php
require_once("conn.php");
require_once("createflags.php");

$winners = "SELECT AUC.auctionId,
                   AUC.winningBid AS bidAmount,
                   BACH.fullName AS bachelor,
                   ATT.fullName AS attendee,
                   ATT.email AS attendeeEmail
            FROM aka.auctions AUC
            JOIN aka.bachelors BACH ON AUC.bachelorId = BACH.bachelorId
            JOIN aka.attendees ATT ON AUC.winningAttendeeId = ATT.attendeeId
            ORDER BY AUC.auctionId ASC";

try {
    $winners_prepared_stmt = $dbo->prepare($winners);
    $winners_prepared_stmt->execute();
    $winners_result = $winners_prepared_stmt->fetchAll();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>View Winners</title>
     <link rel="stylesheet"
           href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="css/master.css">
     <link rel="stylesheet" href="css/view-winners.css">
     <script src="https://apis.google.com/js/platform.js"></script>
     <script type="text/javascript" src="js/google-login.js"></script>
   </head>
   <body>
     <?php
     include_once("header.php");
     ?>
     <table>
       <thead>
         <tr>
           <th>Bachelor</th>
           <th>Winner</th>
           <th>Bid Amount</th>
         </tr>
       </thead>
       <tbody>
         <?php
         if ($winners_result && $winners_prepared_stmt->rowCount() > 0) {
           foreach ($winners_result as $winner) {
             $bachelor = $winner['bachelor'];
             $attendee = $winner['attendee'];
             $bidAmount = $winner['bidAmount'];
             ?>
             <tr>
               <td><?php echo $bachelor; ?></td>
               <td> <?php echo $attendee; ?></td>
               <td><?php echo "$" . $bidAmount; ?></td>
             </tr>
             <?php
           }
         }
          ?>
       </tbody>
     </table>
     <?php
     include_once("overlay.php");
      ?>
      <script type="text/javascript">
          /*This section creates t*/

          function openNav() {
            document.getElementById("myNav").style.width = "100%";
          }

          /* Close when someone clicks on the "x" symbol inside the overlay */
          function closeNav() {
            document.getElementById("myNav").style.width = "0%";
          }

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
