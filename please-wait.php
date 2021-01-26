<?php
require_once('conn.php');
sleep(2);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Please Wait...</title>
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/loader.css">

  </head>
  <body>
    <div id="loader-wrapper">
        <div class="loader"></div>
        <p style="text-align: center;"><strong>You will be redirected to the live auction page soon!</strong></p>
        <script type="text/javascript">
            var getNumAuctions = setInterval(
                function () {
                    var xhttp;
                    xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "check-auctions-null.php", true)
                    xhttp.send();
                    xhttp.onreadystatechange = function () {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            console.log(xhttp.responseText);
                            if (xhttp.responseText == "false") {
                              window.location.href = "live-auction.php";
                            }
                        }
                    }
                }, 2000);
        </script>
    </div>
  </body>
</html>
