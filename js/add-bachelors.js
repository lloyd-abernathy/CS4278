gapi.load('google_scripts', function(){
  google_scripts = gapi.google_scripts.init({
    client_id: "171078891411-7i5ga9cttdoa4u7leqm36eaa013ojj94.apps.googleusercontent.com",
    client_secret: "fPLz76prmNQkXq9oQsIGb6se"
  });


});
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
