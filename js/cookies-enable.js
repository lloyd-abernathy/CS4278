// TODO: Method to check if the cookies are enabled on the site
var cookiesEnabled = navigator.cookieEnabled;
console.log(cookiesEnabled);

if (!cookiesEnabled) {
  console.log("Cookies are not enabled!");
  document.getElementById("cookie_message").style.display = "block";
}
