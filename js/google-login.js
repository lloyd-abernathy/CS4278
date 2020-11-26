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
        //scope: 'profile'
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

    logoutBtn.style.visibility = "hidden";
    accountBtn.style.visibility = "hidden";
    signInBtn.style.visibility = "visible";
}

function hideSignIn() {
    var signInBtn = document.getElementById("sign-in");
    var logoutBtn = document.getElementById("sign-out");
    var accountBtn = document.getElementById("account");

    signInBtn.style.visibility = "hidden";
    logoutBtn.style.visibility = "visible";
    accountBtn.style.visibility = "visible";
}

function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    localStorage.setItem("isUserLoggedIn", true);
    window.location.href = "index.php";
};

function onFailure(error) {
    console.log(error);
};

function signOut() {
    localStorage.setItem("isUserLoggedIn", false);
    auth2.signOut().then(function () {
        console.log('User signed out.');
        var signIn = document.getElementById('sign-in');
        //hideLogoutAndProfile();
        localStorage.setItem("isUserLoggedIn", false);
        //signIn.style.visibility = "visible";
    });
    //window.href.location = "index.php";
};

var userChanged = function (googleUser) {
    // do something
};

function renderButton() {
    gapi.signin2.render('login_google', {
    'scope': 'profile email',
    'width': 240,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': onSuccess,
    'onfailure': onFailure
    });
}
