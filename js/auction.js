
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
// Countdown before event
if (typeof(document.getElementById('label_day')) != undefined) {
  var eventDate = new Date("November 11, 2020 15:15:00");
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
      document.getElementById("event").style.display = "block";
      document.getElementById("bachelor").style.display = "block";
      document.getElementById("about_heartbreaka").style.display = "none";
      document.getElementById("countdown").style.display = "none";
    }
  }, 1000);
}


function createCookie(name, value) {
  var date = new Date();
  date.setTime(date.getTime()+(60*1000));
  var expires = "; expires="+date.toGMTString();

  document.cookie = name+ "=" + value+expires+"; path=/;";
}

function deleteCookie(name) {
  document.cookie = name+ "=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/;";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
