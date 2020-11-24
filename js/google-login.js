var auth2;
var googleUser; // The current user

gapi.load('auth2', function(){

    auth2 = gapi.auth2.init({
        // **********Still need to update this to correct Client ID!!***********
        client_id: '828552978883-a9t18224isla4nd0di12kf133mn4k6n5.apps.googleusercontent.com'
    });
    auth2.attachClickHandler('login_google', {}, onSuccess, onFailure);

    auth2.isSignedIn.listen(signinChanged);
    auth2.currentUser.listen(userChanged); // This is what you use to listen for user changes
});

var signinChanged = function (val) {
    var signUp = document.getElementById("sign-up");
    var accountBtn = document.getElementById("account-btn");
    console.log('Signin state changed to ', val);

    if (val = "true") {
        // hide sign in/sign up
        signUp.style.display = "none";
        // show account button
        accountBtn.style.visibility = "visibile";
        var account = document.getElementsByClassName("dropdown-btn-account");
        var j;

        for (j = 0; j < account.length; j++) {
          account[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownAccount = this.nextElementSibling;
            if (dropdownAccount.style.display === "block") {
              dropdownAccount.style.display = "none";
            } else {
              dropdownAccount.style.display = "block";
            }
          });
        }
    }
};

function hideLogout() {
    var accountBtn = document.getElementById("account-btn");
    accountBtn.style.display = "none";
}

function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    document.getElementById('account-btn').innerHTML += "Hi, " +
                googleUser.getBasicProfile().getName();
    document.getElementById('name').innerText = "Signed in: " +
                googleUser.getBasicProfile().getName();
    // Redirect user to home page
    window.location.href = "index.html";
};

function onFailure(error) {
    console.log(error);
};

function signOut() {
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
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
