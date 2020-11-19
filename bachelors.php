<?php

$dbhost = '';
$dbuname = '';
$dbpass = '';
$dbname = '';

$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

$query = "SELECT * FROM aka.bachelors";

try {
    $prepared_stmt = $dbo->prepare($query);
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
    <title>Home</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/master.css">
    <script type="text/javascript" src="js/bachelors.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script type="text/javascript" src="js/google-login.js"></script>
</head>
<body>

<div id="info">
    <div class="header">
        <div class="header_left">
            <span onclick="openNav()"><i class="fa fa-ellipsis-v"></i></span>
        </div>

        <div class="header_center">
            <h1>Alpha Kappa Alpha Sorority, Inc.</h1>
            <h1>Elegant Eta Beta Chapter</h1>
        </div>

        <div class="header_right">
        </div>
    </div>

    <div id="myNav" class="overlay">

        <!-- Button to close the overlay navigation -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


        <!-- Overlay content -->
        <div class="overlay-content">
            <a href="login.html" class="login" id="sign-up">Sign Up | Login</a><br><br>
            <a href="index.html" id="sign-out" style="display:none"
               onclick="signOut();">Logout</a><br><br>
            <a href="index.html">Home</a>
            <a href="about-chapter.html">About Elegant Eta Beta</a>
            <button class="dropdown-btn">Make Donations <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="donations-money.html">Monetary Donations</a>
                <a href="donations-dropbox.html">Dropbox Donations</a>
                <a id="donations-admin" href="donations-admin-list.html">Donations List</a>
            </div>
            <a href="bachelors.php">Bachelors</a>
            <a href="auction.html">HeartbreAKA Auction</a>
        </div>
    </div>
    <div class="Bachelors">
        <head>
            <style>
                {
                    box-sizing: border-box
                ;
                }
                /* Set additional styling options for the columns */
                .column {
                    float: left;
                    width: 33%;
                    background-color:#FFFFFF;
                }

                .bachelorBlock {
                    vertical-align: top;
                    display: inline-block;
                    text-align: center;
                }

                .bachelorPicture {
                    width: 100px;
                    height: 100px;
                }

                .bg-modal {
                    width: 100%;
                    height: 80%;
                    background-color: rgba(0, 0, 0, 0.7);
                    position: absolute;
                    top: 20%;
                    justify-content: center;
                    align-items: center;
                    display: none;
                }

                .modal-content {
                    width: 80%;
                    height: 80%;
                    background-color: white;
                    text-align: center;
                    padding: 0.5%;
                    position: relative;
                    overflow: auto;
                }

                .overallPopUp {
                }

                .profilePicView {
                    width: 25%;
                    height: 60%;
                    /*float: left;*/
                    /*border-color: #262626;*/
                    border-radius: 1%;
                    padding: 1%;
                    border: 2px solid red;
                }
                .profileBasicInfoView {
                    width: 75%
                    border: 2px solid red;
                }

                .profileNameView {
                    width: 75%
                    border: 2px solid red;
                }



                .profileBiographyView {
                    float: bottom;
                    padding: 1%;
                    /*border: 2px solid red;*/
                    text-align: left;
                }

                input {
                    width: 50%;
                    display: block;
                    margin: 2% auto;
                }

                .close {
                    position: absolute;
                    top: 0;
                    right: 2%;
                    font-size: 42px;
                    transform: rotate(45deg);
                }

                .bachelorLink {
                    cursor: pointer;
                }

                .closeLink {
                    cursor: pointer;
                }

                .row:after {
                    content: "";
                    display: table;
                    clear: both;
                }
            </style>
        </head>
        <body>
        <h2>Bachelors</h2>
        <?php if ($result && $prepared_stmt->rowCount() > 0) {
            foreach ($result as $row) {
                $bachelorID = $row['bachelorId'];
                $bachelorFirstName = $row['firstName'];
                $bachelorLastName = $row['lastName'];
                $bachelorAge = $row['age'];
                $bachelorMajor = $row['major'];
                $bachelorBiography = $row['biography'];
                $bachelorProfilePicture = $row['photoUrl'];
                $bachelorMaxBid = $row['maxBid'];
                $bachelorAuctionStatus = $row['auctionStatus'];
                $bachelorAddedBy = $row['addedBy']; ?>
                <div class="bg-modal" id="<?php echo "bg-modal" . $bachelorID; ?>">
                    <div class="modal-content">
                        <div class="close">
                            <a class="closeLink" onclick="closeBachelorView(<?php echo
                            $bachelorID; ?>)">+</a>
                        </div>
                        <div class="overallPopUp">
                            <img src="https://i.stack.imgur.com/YQu5k.png" class="profilePicView">
                            <div class="profileNameView">
                                <h1><?php echo $bachelorFirstName . " " . $bachelorLastName; ?></h1>
                            </div>
                            <div class="profileBasicInfoView">
                                <h1><?php echo "Major: ".$bachelorMajor;?></h1>
                            </div>
                            <div class="profileBasicInfoView">
                                <h1><?php echo  "Age: ".$bachelorAge;?></h1>
                            </div>
                            <div class="profileAuctionView">
                                <h1>
                                    <?php if($bachelorAuctionStatus == 1) {
                                        echo "<h1>Auction Live</h1>";
                                    } else {
                                        echo "<h1>Auction N/A</h1>";
                                    }?>
                                </h1>
                                <h1><?php echo "Highest Bid: $".$bachelorMaxBid; ?></h1>
                            </div>
                        </div>
                        <div class="profileBiographyView">
                            <h1>Biography: </h1>
                            <p><?php echo $bachelorBiography; ?></p>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="bachelorBlock">
                        <a class="bachelorLink" onclick="getBachelorView(<?php echo $bachelorID; ?>)">
                            <?php echo $bachelorFirstName." ".$bachelorLastName; ?></a>
                        <img src="https://i.stack.imgur.com/YQu5k.png" >
                    </div>
                </div>
            <?php }
        } ?>

        </body>
    </div>

    <script type="text/javascript">
        /*This section creates t*/
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            console.log("Adding click");
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
    <script>
        function getBachelorView(bachelorID) {
            var str = "bg-modal" + bachelorID;
            document.getElementById(str).style.display = 'flex';
        }

        function closeBachelorView(bachelorID) {
            var str = "bg-modal" + bachelorID;
            document.getElementById(str).style.display = 'none';
        }
    </script>
</body>
</html>
