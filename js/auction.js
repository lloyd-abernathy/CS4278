document.getElementsByClassName("buttons")[0].style.display = "none";
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function createCookie(name, value) {
  var date = new Date();
  date.setTime(date.getTime()+(1000*60*60*4));
  var expires = "; expires="+date.toGMTString();

  document.cookie = name+ "=" + value+expires+"; path=/;";
}

var eventDate = new Date("February 12, 2021 19:08:00 -0600");
createCookie("eventDate", eventDate.getTime().toString());
var currDate = new Date().getTime();
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
      console.log("setting displays");
      document.getElementById("countdown").style.display = "none";
      document.getElementsByClassName("buttons")[0].style.display = "block";
      if (document.getElementById("attendee_button") != null) {
        document.getElementById("attendee_button").disabled = false;
        console.log("enabled");
      }
    }
  }, 1000);
