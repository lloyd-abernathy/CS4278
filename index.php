<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body>
<?php include_once("header.php"); ?>

<div class="homepage_info">
    <div class="slideshow" id="slideshow">
        <div class="slides">
            <div class="slide_number">1 / 3</div>
            <img src="images/slideshow/image1.png" alt="">
        </div>
        <div class="slides">
            <div class="slide_number">2 / 3</div>
            <img src="images/slideshow/image2.png" alt="">
        </div>
        <div class="slides">
            <div class="slide_number">3 / 3</div>
            <img src="images/slideshow/instagram.png" alt="">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div id="links" style="height:70px;margin-bottom:10px;width:100%;" class="buttons">
        <form action="bachelors.php">
            <input class="quick_links" type="submit" name="bachelors" value="View Bachelors">
        </form>
        <form action="donations-money.php">
            <input class="quick_links" type="submit" name="bachelors"
                   value="Make Monetary Donation">
        </form>
        <form action="auction.php">
            <input id="auction" class="quick_links" type="submit" name="bachelors"
                   value="Go to Auction">
        </form>
    </div>

    <?php include_once("overlay.php"); ?>
</div>

</div>
</div>


<script type="text/javascript">
    /*This section creates t*/

    var donations = document.getElementsByClassName("dropdown-btn-donations");
    var account = document.getElementsByClassName("dropdown-btn-account");
    var i;
    var j;

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

    for (j = 0; j < account.length; j++) {
        account[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownAccount = this.nextElementSibling;
            if (dropdownAccount.style.display === "block") {
                dropdownAccount.style.display = "none";
            } else {
                dropdownAccount.style.display = "block";
            }
        });
    }
</script>
<script type="text/javascript" src="js/index.js"></script>

</body>
</html>
