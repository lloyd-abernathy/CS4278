let donationAmount = [0.35, 2, 3, 5, 5.5];


function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function updateAKADollars() {
  var donations = document.getElementsByName('donations[]');
  var total = document.getElementsByName('total')[0];
  var dollars = 0;
  var j = 0;
  for (var i = 1; i < donations.length; i = i + 2) {
    dollars = dollars + (donations[i].value * donationAmount[j] * 100);
    j++;
  }

  document.getElementById("aka_dollars").innerHTML = "AKA Dollars Amount: " + dollars;
  total.value = dollars;

}
