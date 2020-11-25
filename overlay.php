<?php
echo
    "<div id=\"myNav\" class=\"overlay\">" .

    // <!-- Button to close the overlay navigation -->
    "<a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>" .

    // <!-- Overlay content -->
    "<div class=\"overlay-content\">" .
    "<a href=\"login.php\" class=\"login\" id=\"sign-up\">Sign Up | Login</a>" .
    "<br>" .
    "<br>" .
    // <!-- Default for Logout button is hidden-- only show when user logged in-->
    "<button id=\"account-btn\" class=\"dropdown-btn-account\" style=\"display:none\">Account
            </button>" .
    "<div class=\"dropdown-container-account\">" .
    "<a href=\"account.php\" id=\"account\">View Profile</a>" .
    "<a href=\"index.php\" id=\"sign-out\" onclick=\"signOut();\">Logout</a><br><br>" .
    "</div>" .
    "<a href=\"index.php\">Home</a>" .
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