let form = document.forms.monetary;

function updateAKADollars() {
  var dollars = form.amount.value;
  document.getElementById("aka_dollars").innerHTML = "AKA Dollars Amount: " + (dollars * 100);
}

// function submitForm() {
//   var paypal = form.service[0];
//   var cashapp = form.service[1];
//   var venmo = form.service[2];
//
//   if (paypal.checked == true) {
//     form.action = "paypal-instructions.html"
//   }
//
//   if (cashapp.checked == true) {
//     form.action = "cashapp-instructions.html"
//   }
//
//   if (venmo.checked == true) {
//     form.action = "venmo-instructions.html"
//   }
// }

function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
