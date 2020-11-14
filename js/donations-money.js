let form = document.forms.monetary;

function updateAKADollars() {
  var dollars = form.amount.value;
  document.getElementById("aka_dollars").innerHTML = "AKA Dollars Amount: " + (dollars * 100);
}

function submitForm() {
  var paypal = form.service[0];
  var cashapp = form.service[1];
  var venmo = form.service[2];

  if (paypal.checked == true) {
    form.action = "paypal-instructions.html"
  }

  if (cashapp.checked == true) {
    form.action = "cashapp-instructions.html"
  }

  if (venmo.checked == true) {
    form.action = "venmo-instructions.html"
  }



}

function addToTable(paymentService){
  var request = new XMLHttpRequest();

  request.addEventListener("load", function(evt){
    console.log(evt);
  }, false);

  request.open('GET', 'donations-admin-list.html', true),
  request.send();
  console.log("adding to table");
  var table = document.getElementById("monetary_donations_list_body");

  var newRow = table.insertRow();

  var nameCell = newRow.insertCell();
  var emailCell = newRow.insertCell();
  var amountCell = newRow.insertCell();
  var serviceCell = newRow.insertCell();
  var approvalCell = newRow.insertCell();

  // Append a text node to the cell
  var fullName = document.createTextNode(form.name.value);
  nameCell.appendChild(fullName);
  var emailAddress = document.createTextNode(form.email.value);
  emailCell.appendChild(emailAddress);
  var dollars = document.createTextNode(form.amount.value);
  amountCell.appendChild(dollars);
  var service = document.createTextNode(paymentService.value);
  serviceCell.appendChild(service);

  // Create the approvalCell contents
  var selectElement = document.createElement("select");
  var approve = document.createElement("option");
  var deny = document.createElement("option");
  approve.value = "Approve";
  approve.text = "Approve";
  deny.value = "Deny";
  deny.text = "Deny";
  selectElement.appendChild(approve);
  selectElement.appendChild(deny);
  approvalCell.appendChild(selectElement);


}

function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
