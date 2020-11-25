function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function moveToRight() {
  var options = $('select.current_order option:selected').sort().clone();
  $('select.new_order').append(options);
  $('select.current_order option:selected').remove();

  var newOptions = $('select.new_order option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}

function moveToLeft() {
  var options = $('select.new_order option:selected').sort().clone();
  $('select.current_order').append(options);
  $('select.new_order option:selected').remove();

  var newOptions = $('select.new_order option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}
