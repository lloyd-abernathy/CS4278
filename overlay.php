<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>

<?php
echo
    "<div id=\"myNav\" class=\"overlay\">" .

    // <!-- Button to close the overlay navigation -->
    "<a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>" .

    // <!-- Overlay content -->
    "<div class=\"overlay-content\">" .
    // <!-- Default for Logout button is hidden-- only show when user logged in-->
    //"<button id=\"account-btn\" class=\"dropdown-btn-account\" style=\"display:none\">Account
     //       </button>" .
    //"<div class=\"dropdown-container-account\">" .
    "<a href=\"login.php\" class=\"login\" id=\"sign-in\">Login</a>" .
    "<a href=\"account.php\" id=\"account\">View Profile</a>" .
    "<a href=\"index.html\" id=\"sign-out\" onclick=\"signOut();\">Logout</a>" .
    //"</div>" .
    "<br>" .
    "<a href=\"index.html\">Home</a>" .
//     "<li class=\"dropdown\">" .
//     "<a href=\"javascript:void(0)\" class=\"dropbtn\">Account</a>" .
//     "<div class=\"dropdown-content\">" .
//       "<a href=\"login.php\">Login</a>" .
//       "<a href=\"logout.php\">Logout</a>" .
//     "</div>" .
//     "</li>" .
    "<a href=\"about-chapter.php\">About Elegant Eta Beta</a>" .
    "<button class=\"dropdown-btn-donations\">Make Donations <i class=\"fa fa-caret-down\"></i>
            </button>" .
    "<div class=\"dropdown-container-donations\">" .
    "<a href=\"donations-money.php\">Monetary Donations</a>" .
    "<a href=\"donations-dropbox.php\">Dropbox Donations</a>" .
    "</div>" .
    "<a href=\"bachelors.php\">Bachelors</a>" .
    "<a href=\"auction.php\">HeartbreAKA Auction</a>" .
    "</div>"
?>