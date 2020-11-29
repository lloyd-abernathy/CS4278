
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

var eventDate = new Date("February 10, 2021 19:08:00");

var countdownInterval = setInterval(function() {
  var currTime = new Date().getTime();

  var untilEvent = eventDate - currTime;

  var days = Math.floor(untilEvent / (1000 * 60 * 60 * 24));
  var hours = Math.floor((untilEvent % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((untilEvent % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((untilEvent % (1000 * 60)) / 1000);

  if (days == 1) {
    document.getElementById('label_day').innerHTML = 'day';
  }
  if (hours == 1) {
    document.getElementById('label_hr').innerHTML = 'hour';
  }
  if (minutes == 1) {
    document.getElementById('label_min').innerHTML = 'minute';
  }
  if (seconds == 1) {
    document.getElementById('label_sec').innerHTML = 'second';
  }

  document.getElementById('num_day').innerHTML = days;
  document.getElementById('num_hr').innerHTML = hours;
  document.getElementById('num_min').innerHTML = minutes;
  document.getElementById('num_sec').innerHTML = seconds;

  if (untilEvent < 0) {
    clearInterval(countdownInterval);
    document.getElementById("event").style.display = "block";
    document.getElementById("about_heartbreaka").style.display = "none";
    document.getElementById("countdown").style.display = "none";
  }
}, 1000);
