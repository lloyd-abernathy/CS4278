<?php
require_once("conn.php");
require_once("createflags.php");
 ?>
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
            <div class="slide_number">1 / 2</div>
            <img src="images/slideshow/image1.png" alt="">
        </div>
        <div class="slides">
            <div class="slide_number">2 / 2</div>
            <img src="images/slideshow/image2.png" alt="">
        </div>
        <!-- <div class="slides">
            <div class="slide_number">3 / 3</div>
            <img src="images/slideshow/instagram.png" alt="">
        </div> -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div class="section">
      <div class="table_info">
        <table>
          <tbody>
            <tr>
              <td><img src="images/homepage/chapter.jpg" alt=""></td>
              <td>
                <h2>About the Elegant Eta Beta Chapter</h2>
                <p>The Elegant Eta Beta Chapter of Alpha Kappa Alpha Sorority, Inc.
                    was chartered on <strong>November 11, 1972</strong>
                    by a group of 13 sophisticated young
                    women from Vanderbilt University and George Peabody College for Teachers.
                    The establishment of our chapter by these dynamic women, made Alpha Kappa
                    Alpha Sorority, Inc. the <strong>FIRST</strong> Black Greek letter sorority at Vanderbilt
                    University. Eta Beta has continued to strive to bring Alpha Kappa Alpha’s
                    purpose of sisterhood, scholarship, and supreme service to all mankind to
                    fruition.</p><br>
                    <form action="about-chapter.php">
                        <input class="quick_links" type="submit" name="about-chapter" value="Learn More About the Elegant Eta Beta Chapter">
                    </form>
              </td>
            </tr>
            <tr>

            </tr>
          </tbody>
        </table>
      </div>

    </div>

    <div class="section">
      <div class="table_info">
        <table>
          <tbody>
            <tr>
              <td>
                <h2>About HeartbreAKA</h2>
                <p>In accordance with our current initiatives, the Elegant Eta Beta Chapter
                    of Alpha Kappa Alpha Sorority Inc. hosts HeartbreAKA every year to raise
                    money for an important cause. HeartbreAKA is a date auction where
                    attendees bid on the eligible bachelors being presented to win a
                    complimentary group date with the chapter. <br><br>
                    <strong>Do you want to attend this event?</strong>
                     Login to your Google account and begin donating supplies and
                     money to get AKA dollars that you can use at the event.</p><br>
                    <form action="bachelors.php">
                        <input class="quick_links" type="submit" name="bachelors" value="View Bachelors">
                    </form>
                    <form action="donations-money.php">
                        <input class="quick_links" type="submit" name="bachelors"
                               value="Make Monetary Donation">
                    </form>
                    <form action="donations-dropbox.php">
                        <input class="quick_links" type="submit" name="bachelors"
                               value="Make Donation Via Dropbox">
                    </form>
                    <form action="auction.php">
                        <input id="auction" class="quick_links" type="submit" name="bachelors"
                               value="Go to Auction">
                    </form>
              </td>
              <td><img src="images/homepage/heartbreaka.jpg" alt=""></td>
            </tr>
            <tr>

            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="section" id="instagram">
      <div class="table_info">
        <table>
          <tbody>
            <tr>
              <td>
                <h2>Follow Us on Instagram:
                  <a href="https://www.instagram.com/elegantetabeta/">@elegantetabeta</a></h2>
                  <!-- <p>Follow us on Instagram
                    <a href="https://www.instagram.com/elegantetabeta/"><strong>@elegantetabeta</strong></a>
                    to stay up to date with upcoming events!</p> -->
              </td>
            </tr>
            <tr>
              <td>
                <!-- Place <div> tag where you want the feed to appear -->
                <div id="curator-feed-default-feed-layout"><a href="https://curator.io" target="_blank" class="crt-logo crt-tag">Powered by Curator.io</a></div>
                <!-- The Javascript can be moved to the end of the html page before the </body> tag -->
                <script type="text/javascript">
                /* curator-feed-default-feed-layout */
                (function(){
                var i, e, d = document, s = "script";i = d.createElement("script");i.async = 1;
                i.src = "https://cdn.curator.io/published/2931f676-8439-4444-a8b7-4c1ae868a7fc.js";
                e = d.getElementsByTagName(s)[0];e.parentNode.insertBefore(i, e);
                })();
                </script>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
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