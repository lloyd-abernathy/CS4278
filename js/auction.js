
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
var eventDate = new Date("February 10, 2021, 19:08:00");
var currDate = new Date().getTime();
// Countdown before event
if ((eventDate - currDate) >= 0 ) {
  console.log(eventDate - currDate);
  document.getElementById("about_heartbreaka").style.display = "block";
  document.getElementById("countdown").style.display = "block";
  document.getElementById("event").style.display = "none";
  document.getElementById("bachelor").style.display = "none";
} else {
  document.getElementById("event").style.display = "block";
  document.getElementById("bachelor").style.display = "block";
  document.getElementById("about_heartbreaka").style.display = "none";
  document.getElementById("countdown").style.display = "none";
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
