function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function showForm() {
  console.log(document.readyState);
  if (document.readyState == "complete") {
    var selected_options = $('select.bachelor_signup option.bachelor:selected');
    console.log(selected_options);
    var options = $('select.bachelor_signup option.bachelor:not(:selected)');
    console.log(options);

    document.getElementById('bachelor_signup_info').style.visibility = "visible";

    for (var i = 0; i < selected_options.length; i++) {
      console.log(selected_options[i].value);
      console.log(document.getElementById("form-" + selected_options[i].value));
      document.getElementById("form-" + selected_options[i].value).style.display = "block";
      document.getElementById("title-" + selected_options[i].value).style.display = "block";
    }

    for (var j = 0; j < options.length; j++) {
      console.log(document.getElementById("form-" + options[j].value));
      document.getElementById("form-" + options[j].value).style.display = "none";
      document.getElementById("title-" + options[j].value).style.display = "none";
    }
  }
}

function moveToRight() {
  var options = $('select.bachelor_signup option:selected').sort().clone();
  $('select.bachelor_approved').append(options);
  $('select.bachelor_signup option:selected').remove();

  var newOptions = $('select.bachelor_approved option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}

function moveToLeft() {
  var options = $('select.bachelor_approved option:selected').sort().clone();
  $('select.bachelor_signup').append(options);
  $('select.bachelor_approved option:selected').remove();

  var newOptions = $('select.bachelor_approved option').sort()
  for (var i = 0; i < newOptions.length; i++) {
    newOptions[i].selected = "true";
  }
}
