function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function disableInput() {
  var class_input = document.getElementById("class_input");
  class_input.disabled = "true";
}
