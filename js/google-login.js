var auth2;
var googleUser; // The current user

/**
 * Calls startAuth after Sign in V2 finishes setting up.
 */
var appStart = function() {
    gapi.load('auth2', initSigninV2);
  };

  /**
   * Initializes Signin v2 and sets up listeners.
   */
  var initSigninV2 = function() {
    auth2 = gapi.auth2.init({
        client_id: '171078891411-7i5ga9cttdoa4u7leqm36eaa013ojj94.apps.googleusercontent.com',
        scope: 'profile'
    });

    auth2.attachClickHandler('login_google', {}, onSuccess, onFailure);

    // Listen for sign-in state changes.
    auth2.isSignedIn.listen(signinChanged);

    // Listen for changes to current user.
    auth2.currentUser.listen(userChanged);

    // Sign in the user if they are currently signed in.
    if (auth2.isSignedIn.get() == true) {auth2.signIn();
    }

    // Start with the current live values.
    refreshValues();
  };


window.onload = function () {

    if (localStorage.getItem("isUserLoggedIn") == null || localStorage.getItem("isUserLoggedIn") == "false") {
        // Hide Logout and Profile buttons when no one has logged in yet
        hideLogoutAndProfile();
    } else {
        // someone is logged in -- hide sign in
        hideSignIn();
    }
}

var signinChanged = function (val) {
    console.log('Signin state changed to ', val);

    if (val = "true") {
        localStorage.setItem("isUserLoggedIn", true);
    }
};

function hideLogoutAndProfile() {
    var logoutBtn = document.getElementById("sign-out");
    var accountBtn = document.getElementById("account");
    var signInBtn = document.getElementById("sign-in");

    logoutBtn.style.display = "none";
    accountBtn.style.display = "none";
    signInBtn.style.display = "block";
}

function hideSignIn() {
    var signInBtn = document.getElementById("sign-in");
    var logoutBtn = document.getElementById("sign-out");
    var accountBtn = document.getElementById("account");

    signInBtn.style.display = "none";
    logoutBtn.style.display = "block";
    accountBtn.style.display = "block";
}

function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    console.log('Logged in as: ' + googleUser.getBasicProfile().getEmail());
    createCookie("fullName", googleUser.getBasicProfile().getName());
    createCookie("email", googleUser.getBasicProfile().getEmail());
    localStorage.setItem("isUserLoggedIn", true);
    window.location.href = "login.php";
};

function onFailure(error) {
    console.log(error);
};

function signOut() {
    deleteCookie("fullName");
    deleteCookie("email");
    deleteCookie("timer");
    deleteCookie("startTime");
    deleteCookie("endTime");
    localStorage.setItem("isUserLoggedIn", false);

    auth2.signOut().then(function () {
        console.log('User signed out.');
        deleteCookie("fullName");
        deleteCookie("email");
        deleteCookie("timer");
        deleteCookie("startTime");
        deleteCookie("endTime");
        var signIn = document.getElementById('sign-in');
        //hideLogoutAndProfile();
        localStorage.setItem("isUserLoggedIn", false);
        //signIn.style.visibility = "visible";
    });
    //window.href.location = "index.html";
};

var userChanged = function (googleUser) {
    // do something
};

function renderButton() {
    gapi.signin2.render('login_google', {
    'scope': 'profile email',
    'width': 200,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': onSuccess,
    'onfailure': onFailure
    });
};

function createCookie(name, value) {
  var date = new Date();
  date.setTime(date.getTime()+(24*60*60*1000));
  var expires = "; expires="+date.toGMTString();

  document.cookie = name+ "=" + value+expires+"; path=/;";
}

function deleteCookie(name) {
  document.cookie = name+ "=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/;";
}
