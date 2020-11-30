<?php
require_once("conn.php");
require_once("create_flags");

$winners = "SELECT * FROM auctions";

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
     <script type="text/javascript" src="js/auction.js"></script>
     <script src="https://apis.google.com/js/platform.js"></script>
     <script type="text/javascript" src="js/google-login.js"></script>
   </head>
   <body>

   </body>
 </html>
